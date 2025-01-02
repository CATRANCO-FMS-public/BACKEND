<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\TrackerVehicleMapping;
use App\Models\VehicleAssignment;
use App\Models\DispatchLogs;
use App\Events\FlespiDataReceived;
use Illuminate\Support\Facades\Cache;

class FlespiController extends Controller
{

    /**
     * Handle incoming data from the Flespi stream.
     */
    public function handleData(Request $request)
    {
        // Define a threshold for detecting repeated coordinates
        $repetitionThreshold = 1; // Adjust this as needed

        // Extract Flespi data (assuming it's in an array)
        $dataList = $request->all();

        if (!is_array($dataList) || count($dataList) === 0) {
            Log::warning("No valid data received.");
            return response()->json(['status' => 'failed', 'message' => 'No data found']);
        }

        $responses = [];

        foreach ($dataList as $data) {
            // Extract individual fields from the data
            $trackerIdent = $data['Ident'] ?? null;
            $latitude = $data['PositionLatitude'] ?? null;
            $longitude = $data['PositionLongitude'] ?? null;
            $speed = $data['PositionSpeed'] ?? null;
            $timestamp = $data['Timestamp'] ?? null;

            if (!$trackerIdent) {
                Log::warning("Tracker identifier is missing.");
                $responses[] = ['status' => 'failed', 'message' => 'Tracker identifier missing'];
                continue;
            }

            // Match tracker to a vehicle using TrackerVehicleMapping
            $vehicleId = TrackerVehicleMapping::where('tracker_ident', $trackerIdent)->value('vehicle_id');

            if (!$vehicleId) {
                Log::warning("No vehicle found for tracker identifier: $trackerIdent.");
                $responses[] = ['status' => 'failed', 'message' => 'No vehicle found for tracker'];
                continue;
            }

            // Fetch the vehicle details to get plate number
            $vehicle = VehicleAssignment::where('vehicle_id', $vehicleId)->first()->vehicle;

            // Fetch the vehicle assignment for the vehicle
            $vehicleAssignment = VehicleAssignment::where('vehicle_id', $vehicleId)->first();

            if (!$vehicleAssignment) {
                Log::warning("No vehicle assignment found for vehicle ID: $vehicleId.");
                $responses[] = ['status' => 'failed', 'message' => 'No vehicle assignment found'];
                continue;
            }

            // Fetch the active dispatch log for the vehicle assignment
            $dispatchLog = DispatchLogs::where('vehicle_assignment_id', $vehicleAssignment->vehicle_assignment_id)
                ->whereIn('status', ['on alley', 'on road'])
                ->with(['vehicleAssignments.vehicle', 'vehicleAssignments.userProfiles'])
                ->first();

            // Log if a dispatch log was found or not
            if ($dispatchLog) {
                Log::info("Found active dispatch log for vehicle ID: $vehicleId", [
                    'dispatch_log_id' => $dispatchLog->dispatch_logs_id,
                    'status' => $dispatchLog->status,
                    'vehicle_assignment_id' => $dispatchLog->vehicle_assignment_id,
                ]);
            } else {
                Log::info("No active dispatch log found for vehicle ID: $vehicleId.");
            }

            // Generate a unique key for the latitude and longitude
            $coordinateKey = "coordinates:{$vehicleId}:{$latitude}:{$longitude}";

            // Store this key in a separate cache list
            $vehicleKeysKey = "vehicle:{$vehicleId}:cache_keys";
            $vehicleKeys = Cache::get($vehicleKeysKey, []);
            $vehicleKeys[] = $coordinateKey;
            Cache::put($vehicleKeysKey, $vehicleKeys, now()->addHour()); // Expire after 1 hour

            // Increment the frequency count in the cache (file-based cache)
            $currentCount = Cache::increment($coordinateKey);

            // Set an expiration time for the cache key (e.g., 1 hour)
            Cache::put($coordinateKey, $currentCount, now()->addHour());

            // Check if the coordinate is blacklisted
            if ($currentCount > $repetitionThreshold) {
                Log::info("Ignoring repeated coordinates for tracker $trackerIdent: latitude $latitude, longitude $longitude. Count: $currentCount.");
                $responses[] = ['status' => 'ignored', 'message' => 'Coordinates are frequently repeated'];
                continue;
            }

            // Log tracker movement status
            if ($speed > 0) {
                Log::info("Tracker $trackerIdent is moving.", $data);
            } else {
                Log::info("Tracker $trackerIdent is stationary.", $data);
            }

            // Check if the dispatch is completed and reset blocked locations
            if ($vehicleId && $dispatchLog && $dispatchLog->status === 'completed') {
                $this->resetBlockedLocations($vehicleId);
                Log::info("Reset blocked locations for vehicle $vehicleId after dispatch completion.");
            }

            // Prepare data for broadcast
            $broadcastData = [
                'tracker_ident' => $trackerIdent,
                'vehicle_id' => $vehicleId,
                'plate_number' => $vehicle->plate_number,
                'location' => [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'speed' => $speed,
                ],
                'timestamp' => $timestamp,
                'dispatch_log' => $dispatchLog ? [
                    'dispatch_logs_id' => $dispatchLog->dispatch_logs_id,
                    'start_time' => $dispatchLog->start_time,
                    'end_time' => $dispatchLog->end_time,
                    'status' => $dispatchLog->status,
                    'route' => $dispatchLog->route,
                    'vehicle_assignment' => [
                        'vehicle_assignment_id' => $dispatchLog->vehicleAssignments->vehicle_assignment_id,
                        'user_profiles' => $dispatchLog->vehicleAssignments->userProfiles->map(function ($profile) {
                            return [
                                'user_profile_id' => $profile->user_profile_id,
                                'name' => "{$profile->first_name} {$profile->last_name}",
                                'position' => $profile->position,
                                'status' => $profile->status,
                            ];
                        }),
                    ],
                ] : null,
            ];

            // Log the data being broadcasted
            Log::info("Broadcasting data", $broadcastData);

            // Broadcast data to the frontend
            broadcast(new FlespiDataReceived($broadcastData));

            $responses[] = ['status' => 'success', 'tracker_ident' => $trackerIdent];
        }

        return response()->json(['status' => 'processed', 'responses' => $responses]);
    }


    /**
     * Reset the blocked locations for a given vehicle.
     */
    private function resetBlockedLocations($vehicleId)
    {
        // Retrieve the list of keys associated with the vehicle
        $vehicleKeysKey = "vehicle:{$vehicleId}:cache_keys";
        $vehicleKeys = Cache::get($vehicleKeysKey, []);

        foreach ($vehicleKeys as $key) {
            Cache::forget($key); // Remove each cached key
        }

        // Optionally, remove the vehicle's cache key list
        Cache::forget($vehicleKeysKey);

        Log::info("Blocked locations reset for vehicle ID: $vehicleId.");
    }


    
    /**
     * Reset the blocked locations for all vehicles.
     */
    public function resetBlockedLocationsForAllVehicles()
    {
        // Get all vehicle IDs (you can adjust this to match your actual data source)
        $vehicleIds = VehicleAssignment::pluck('vehicle_id');

        foreach ($vehicleIds as $vehicleId) {
            $this->resetBlockedLocations($vehicleId);
        }

        return response()->json(['status' => 'success', 'message' => 'Blocked locations reset for all vehicles.']);
    }

}
