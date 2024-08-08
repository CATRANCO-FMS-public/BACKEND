<?php

namespace App\Http\Controllers;

use App\Http\Requests\DispatchLogsStoreRequest;
use App\Models\DispatchLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DispatchLogsController extends Controller
{
    // Get all dispatch logs
    public function getAllDispatchLogs() {
        $dispatchlogs = DispatchLogs::with(['fuelLogs', 'vehicleAssignments.vehicle', 'vehicleAssignments.userProfile'])->get();
        return response()->json($dispatchlogs);
    }

    // Create a new dispatch log
    public function createDispatchLog(DispatchLogsStoreRequest $request) {
        try {
            $data = $request->validated();
            $data['created_by'] = Auth::id(); // Automatically set created_by
            $dispatchlog = DispatchLogs::create($data);
    
            // Attach vehicle assignments with timestamps
            if (isset($data['vehicle_assignment_ids'])) {
                $timestamp = now(); // Get the current timestamp
                $dispatchlog->vehicleAssignments()->attach(
                    $data['vehicle_assignment_ids'], 
                    ['created_at' => $timestamp, 'updated_at' => $timestamp]
                );
            }
    
            return response()->json(["message" => "Dispatch Log Successfully Created", "dispatchlog" => $dispatchlog], 201);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }
    

    // Get a specific dispatch log by ID
    public function getDispatchLogById($id) {
        try {
            $dispatchlog = DispatchLogs::with(['fuelLogs', 'vehicleAssignments.vehicle', 'vehicleAssignments.userProfile'])->findOrFail($id);
            return response()->json($dispatchlog);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 404);
        }
    }

    // Update a specific dispatch log by ID
    public function updateDispatchLog(DispatchLogsStoreRequest $request, $id) {
        try {
            $dispatchlog = DispatchLogs::findOrFail($id);
            $data = $request->validated();
            $data['updated_by'] = Auth::id(); // Automatically set updated_by
            $dispatchlog->update([
                'fuel_logs_id' => $data['fuel_logs_id'],
                'updated_by' => $data['updated_by']
            ]);

            // Sync vehicle assignments
            if (isset($data['vehicle_assignment_ids'])) {
                $dispatchlog->vehicleAssignments()->sync($data['vehicle_assignment_ids']);
            }

            return response()->json(["message" => "Dispatch Log Updated Successfully", "dispatchlog" => $dispatchlog], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    // Delete a specific dispatch log by ID
    public function deleteDispatchLog($id) {
        try {
            $dispatchlog = DispatchLogs::findOrFail($id);
            $dispatchlog->deleted_by = Auth::id(); // Automatically set deleted_by
            $dispatchlog->save();
            $dispatchlog->delete();
            return response()->json(["message" => "Dispatch Log Deleted Successfully"], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }
}

