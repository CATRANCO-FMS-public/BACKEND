<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaintenanceSchedulingRequest\MaintenanceSchedulingRequest;
use App\Http\Requests\MaintenanceSchedulingRequest\MaintenanceSchedulingUpdateRequest;
use App\Http\Requests\MaintenanceSchedulingRequest\ToggleMaintenanceStatusRequest;
use App\Models\MaintenanceScheduling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceSchedulingController extends Controller
{
    // Get all maintenance schedules
    public function getAllMaintenanceScheduling() {
        $schedules = MaintenanceScheduling::all();
        return response()->json($schedules);
    }

    // Create a new maintenance schedule
    public function createMaintenanceScheduling(MaintenanceSchedulingRequest $request) {
        try {
            $data = $request->validated();
            $data['created_by'] = Auth::id(); // Automatically set created_by
            $data['maintenance_status'] = 'active'; // Default maintenance status to 'active'

            $schedule = MaintenanceScheduling::create($data);

            return response()->json([
                "message" => "Maintenance Schedule Successfully Created",
                "schedule" => $schedule
            ], 201);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    // Get a specific maintenance schedule by ID
    public function getMaintenanceSchedulingById($id) {
        try {
            $schedule = MaintenanceScheduling::findOrFail($id);
            return response()->json($schedule);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 404);
        }
    }

    // Update a specific maintenance schedule by ID
    public function updateMaintenanceScheduling(MaintenanceSchedulingUpdateRequest $request, $id) {
        try {
            $schedule = MaintenanceScheduling::findOrFail($id);
            $data = $request->validated();
            $data['updated_by'] = Auth::id(); // Automatically set updated_by
            $schedule->update($data);
            return response()->json(["message" => "Maintenance Schedule Updated Successfully", "schedule" => $schedule], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    // Delete a specific maintenance schedule by ID
    public function deleteMaintenanceScheduling($id) {
        try {
            $schedule = MaintenanceScheduling::findOrFail($id);
            $schedule->deleted_by = Auth::id(); // Automatically set deleted_by
            $schedule->save();
            $schedule->delete();
            return response()->json(["message" => "Maintenance Schedule Deleted Successfully"], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    // Toggle the maintenance status from active to completed
    public function toggleMaintenanceStatus(ToggleMaintenanceStatusRequest $request, $id)
    {
        try {
            // Find the maintenance schedule by ID
            $schedule = MaintenanceScheduling::findOrFail($id);

            // Ensure the status can only be toggled from 'active' to 'completed'
            if ($schedule->maintenance_status === 'completed') {
                return response()->json([
                    "message" => "Maintenance status is already completed and cannot be changed back to active."
                ], 400);
            }

            // Check if proof file is required for toggling to 'completed'
            if ($schedule->maintenance_status === 'active' && $request->hasFile('maintenance_complete_proof')) {
                // Handle proof file upload
                $proofPath = $request->file('maintenance_complete_proof')->store('maintenance_proofs', 'public');
                $schedule->maintenance_complete_proof = $proofPath;
            } elseif ($schedule->maintenance_status === 'active' && !$request->hasFile('maintenance_complete_proof')) {
                return response()->json([
                    "message" => "Proof is required to mark maintenance as completed."
                ], 400);
            }

            // Update the status to 'completed'
            $schedule->maintenance_status = 'completed';

            // Update the user who toggled the status
            $schedule->updated_by = Auth::id();

            // Save the updated schedule
            $schedule->save();

            return response()->json([
                "message" => "Maintenance status successfully updated to completed.",
                "schedule" => $schedule
            ], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    // Get all active maintenance schedules
    public function getAllActiveMaintenance() {
        try {
            $activeSchedules = MaintenanceScheduling::where('maintenance_status', 'active')->get();
            return response()->json([
                "data" => $activeSchedules
            ], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    // Get all completed maintenance schedules
    public function getAllCompletedMaintenance() {
        try {
            $completedSchedules = MaintenanceScheduling::where('maintenance_status', 'completed')->get();
            return response()->json([
                "data" => $completedSchedules
            ], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }
}
