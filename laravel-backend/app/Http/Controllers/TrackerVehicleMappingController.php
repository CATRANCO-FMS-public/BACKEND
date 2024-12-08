<?php

namespace App\Http\Controllers;

use App\Models\TrackerVehicleMapping;
use App\Http\Requests\StoreTrackerVehicleMappingRequest;
use App\Http\Requests\UpdateTrackerVehicleMappingRequest;

class TrackerVehicleMappingController extends Controller
{
    // Fetch all tracker-to-vehicle mappings
    public function getAllTrackerVehicleMappings()
    {
        $mappings = TrackerVehicleMapping::with('vehicle')->get();

        return response()->json(['data' => $mappings]);
    }

    // Create a new tracker-to-vehicle mapping
    public function createTrackerVehicleMapping(StoreTrackerVehicleMappingRequest $request)
    {
        $mapping = TrackerVehicleMapping::create($request->validated());

        return response()->json(['message' => 'Tracker-to-Vehicle Mapping created successfully', 'data' => $mapping], 201);
    }

    // Update an existing tracker-to-vehicle mapping
    public function updateTrackerVehicleMapping(UpdateTrackerVehicleMappingRequest $request, $id)
    {
        $mapping = TrackerVehicleMapping::findOrFail($id);
        $mapping->update($request->validated());

        return response()->json(['message' => 'Tracker-to-Vehicle Mapping updated successfully', 'data' => $mapping]);
    }

    // Delete a tracker-to-vehicle mapping
    public function deleteTrackerVehicleMapping($id)
    {
        $mapping = TrackerVehicleMapping::findOrFail($id);
        $mapping->delete();

        return response()->json(['message' => 'Tracker-to-Vehicle Mapping deleted successfully']);
    }
}
