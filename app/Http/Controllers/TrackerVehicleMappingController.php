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

    // Fetch a specific tracker-to-vehicle mapping by ID
    public function getTrackerVehicleMappingById($id)
    {
        $mapping = TrackerVehicleMapping::with('vehicle')->findOrFail($id);

        return response()->json(['data' => $mapping]);
    }

    // Create a new tracker-to-vehicle mapping and set status to active
    public function createTrackerVehicleMapping(StoreTrackerVehicleMappingRequest $request)
    {
        // Add status as active when creating
        $data = $request->validated();
        $data['status'] = 'active'; // Set status to active by default

        // Create the mapping
        $mapping = TrackerVehicleMapping::create($data);

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

    // Set the status of a tracker-to-vehicle mapping to inactive
    public function setStatusInactive($id)
    {
        $mapping = TrackerVehicleMapping::findOrFail($id);
        $mapping->update(['status' => 'inactive']); // Set status to inactive

        return response()->json(['message' => 'Tracker-to-Vehicle Mapping status updated to inactive', 'data' => $mapping]);
    }
}
