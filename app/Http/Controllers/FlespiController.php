<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\TrackerVehicleMapping;
use App\Models\DispatchLogs;
use App\Events\FlespiDataReceived;

class FlespiController extends Controller
{
    /**
     * Handle incoming data from the Flespi stream.
     */
    public function handleData(Request $request)
    {
        // Extract Flespi data (assuming it's in an array)
        $data = $request->all();

        if (is_array($data) && count($data) > 0) {
            // Extract the first item from the array
            $data = $data[0];
        } else {
            Log::warning("No valid data received.");
            return response()->json(['status' => 'failed', 'message' => 'No data found']);
        }

        // Log the extracted data for debugging
        Log::info("Extracted Flespi Data:", $data);

        // Extract individual fields from the data
        $trackerIdent = $data['Ident'] ?? null;
        $latitude = $data['PositionLatitude'] ?? null;
        $longitude = $data['PositionLongitude'] ?? null;
        $speed = $data['PositionSpeed'] ?? null;
        $timestamp = $data['Timestamp'] ?? null;

        // Log tracker movement status
        if ($speed > 0) {
            Log::info("Tracker $trackerIdent is moving.", $data);
        } else {
            Log::info("Tracker $trackerIdent is stationary.", $data);
        }

        // Match tracker to a vehicle using TrackerVehicleMapping
        $vehicleId = null;
        if ($trackerIdent) {
            $vehicleId = TrackerVehicleMapping::where('tracker_ident', $trackerIdent)->value('vehicle_id');
            Log::info("Found vehicleId: $vehicleId for tracker $trackerIdent");
        } else {
            Log::warning("No tracker_ident provided in the data.");
        }

        // Fetch the active dispatch log for the vehicle
        $dispatchLog = null;
        if ($vehicleId) {
            $dispatchLog = DispatchLogs::where('vehicle_assignment_id', $vehicleId)
                ->whereIn('status', ['on alley', 'on road'])
                ->first();
        }

        // Log dispatch log details if found
        if ($dispatchLog) {
            Log::info("Dispatch log found for tracker $trackerIdent.", ['dispatch_logs_id' => $dispatchLog->dispatch_logs_id]);
        } else {
            Log::warning("No active dispatch log found for tracker $trackerIdent.");
        }

        // Prepare data for broadcasting
        $broadcastData = [
            'tracker_ident' => $trackerIdent,
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

        // sleep(5);

        return response()->json(['status' => 'success']);
    }
}
