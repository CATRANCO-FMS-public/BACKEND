<?php

namespace App\Http\Controllers;

use App\Models\VehicleOverspeedTracking;
use App\Http\Requests\VehicleOverspeedTrackingRequest;
use Illuminate\Support\Carbon;

class VehicleOverspeedTrackingController extends Controller
{
    // Get all overspeed records
    public function getVehicleOverspeed()
    {
        $overspeeds = VehicleOverspeedTracking::with('vehicle', 'dispatchTrackingOverspeed.vehicleAssignments.userProfiles')->get();
        return response()->json($overspeeds);
    }

    // Create a new overspeed record
    public function createVehicleOverspeed(VehicleOverspeedTrackingRequest $request)
    {
        $data = $request->validated();
        $data['overspeed_timestamp'] = Carbon::now(); // Automatically set the timestamp

        $overspeed = VehicleOverspeedTracking::create($data);

        return response()->json(['message' => 'Overspeed record created successfully', 'data' => $overspeed], 201);
    }

    // Delete a specific overspeed record
    public function deleteVehicleOverspeed($id)
    { 
        $overspeed = VehicleOverspeedTracking::find($id);

        if (!$overspeed) {
            return response()->json(['message' => 'Overspeed record not found'], 404);
        }

        $overspeed->delete();

        return response()->json(['message' => 'Overspeed record deleted successfully']);
    }

    // Delete overspeed records by date
    public function deleteOverspeedByDate($date)
    {
        // Ensure the date format is correct
        $carbonDate = Carbon::createFromFormat('Y-m-d', $date)->startOfDay();

        // Delete records matching the selected date
        $deletedCount = VehicleOverspeedTracking::whereDate('overspeed_timestamp', $carbonDate)->delete();

        if ($deletedCount > 0) {
            return response()->json(['message' => "$deletedCount overspeed records deleted successfully"]);
        } else {
            return response()->json(['message' => 'No records found for the given date'], 404);
        }
    }
}
