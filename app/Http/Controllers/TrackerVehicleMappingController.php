<?php

namespace App\Http\Controllers;

use App\Models\TrackerVehicleMapping;
use App\Http\Requests\StoreTrackerVehicleMappingRequest;
use App\Http\Requests\UpdateTrackerVehicleMappingRequest;
use Illuminate\Support\Facades\Auth;

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
        // Add status as active and set created_by to current user
        $data = $request->validated();
        $data['status'] = 'active'; // Set status to active by default
        $data['created_by'] = Auth::id(); // Set created_by to current authenticated user

        // Create the mapping
        $mapping = TrackerVehicleMapping::create($data);

        return response()->json(['message' => 'Tracker-to-Vehicle Mapping created successfully', 'data' => $mapping], 201);
    }

    // Update an existing tracker-to-vehicle mapping
    public function updateTrackerVehicleMapping(UpdateTrackerVehicleMappingRequest $request, $id)
    {
        $mapping = TrackerVehicleMapping::findOrFail($id);
        
        // Set updated_by to current user
        $data = $request->validated();
        $data['updated_by'] = Auth::id(); // Set updated_by to current authenticated user
        
        $mapping->update($data);

        return response()->json(['message' => 'Tracker-to-Vehicle Mapping updated successfully', 'data' => $mapping]);
    }

    // Delete a tracker-to-vehicle mapping
    public function deleteTrackerVehicleMapping($id)
    {
        $mapping = TrackerVehicleMapping::findOrFail($id);
        
        // Set deleted_by to current user and perform soft delete
        $mapping->deleted_by = Auth::id(); // Set deleted_by to current authenticated user
        $mapping->save();
        $mapping->delete(); // Soft delete

        return response()->json(['message' => 'Tracker-to-Vehicle Mapping deleted successfully']);
    }

    // Toggle the status of a tracker-to-vehicle mapping
    public function toggleTrackerVehicleMappingStatus($id)
    {
        $mapping = TrackerVehicleMapping::findOrFail($id);
        
        // Check current status and toggle it
        $newStatus = $mapping->status === 'active' ? 'inactive' : 'active';
        
        // Update the status and updated_by
        $mapping->update([
            'status' => $newStatus,
            'updated_by' => Auth::id() // Set updated_by to current authenticated user
        ]);

        return response()->json(['message' => 'Tracker-to-Vehicle Mapping status toggled', 'data' => $mapping]);
    }

}
