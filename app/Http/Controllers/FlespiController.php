<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\TrackerVehicleMapping;
use App\Models\DispatchLogs;
use App\Events\FlespiDataReceived;
use Illuminate\Support\Facades\Cache;

class FlespiController extends Controller
{
    // Predefined blacklist of coordinates
    protected $blacklistedCoordinates = [
        ['latitude' => 8.458932, 'longitude' => 124.6326], // Example coordinate
        ['latitude' => 8.458825, 'longitude' => 124.632733], // Example coordinate
    ];

    /**
     * Handle incoming data from the Flespi stream.
     */
    public function handleData(Request $request)
    {
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

            // Check if the coordinates are blacklisted
            foreach ($this->blacklistedCoordinates as $blacklisted) {
                if ($blacklisted['latitude'] == $latitude && $blacklisted['longitude'] == $longitude) {
                    Log::info("Ignoring blacklisted coordinates for tracker $trackerIdent: latitude $latitude, longitude $longitude.");
                    $responses[] = ['status' => 'ignored', 'message' => 'Coordinates are blacklisted'];
                    continue 2; // Skip this tracker
                }
            }

            // // Cache key for tracker
            // $cacheKey = "tracker_coordinates_$trackerIdent";

            // // Retrieve last known coordinates from the cache
            // $lastCoordinates = Cache::get($cacheKey);

            // if ($lastCoordinates && $lastCoordinates['latitude'] == $latitude && $lastCoordinates['longitude'] == $longitude) {
            //     Log::info("Ignoring repeated coordinates for tracker $trackerIdent with latitude: $latitude, longitude: $longitude.");
            //     $responses[] = ['status' => 'ignored', 'message' => 'Repeated coordinates'];
            //     continue;
            // }

            // // Update cache
            // Cache::put($cacheKey, ['latitude' => $latitude, 'longitude' => $longitude], now()->addMinutes(5));

            // Log tracker movement status
            if ($speed > 0) {
                Log::info("Tracker $trackerIdent is moving.", $data);
            } else {
                Log::info("Tracker $trackerIdent is stationary.", $data);
            }

            // Match tracker to a vehicle using TrackerVehicleMapping
            $vehicleId = TrackerVehicleMapping::where('tracker_ident', $trackerIdent)->value('vehicle_id');

            // Fetch the active dispatch log for the vehicle
            $dispatchLog = null;
            if ($vehicleId) {
                $dispatchLog = DispatchLogs::where('vehicle_assignment_id', $vehicleId)
                    ->whereIn('status', ['on alley', 'on road'])
                    ->first();
            }

            // Prepare data for broadcasting
            $broadcastData = [
                'tracker_ident' => $trackerIdent,
                'vehicle_id' => $vehicleId,
                'location' => [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'speed' => $speed,
                ],
                'timestamp' => $timestamp,
                'dispatch_log' => $dispatchLog,
            ];

            // Log the data being broadcasted
            Log::info("Broadcasting data", $broadcastData);

            // Broadcast data to the frontend
            broadcast(new FlespiDataReceived($broadcastData));

            $responses[] = ['status' => 'success', 'tracker_ident' => $trackerIdent];
        }

        return response()->json(['status' => 'processed', 'responses' => $responses]);
    }
}
