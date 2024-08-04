<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaintenanceSchedulingRequest;
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
            $schedule = MaintenanceScheduling::create($data);
            return response()->json(["message" => "Maintenance Schedule Successfully Created", "schedule" => $schedule], 201);
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
    public function updateMaintenanceScheduling(MaintenanceSchedulingRequest $request, $id) {
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
}
