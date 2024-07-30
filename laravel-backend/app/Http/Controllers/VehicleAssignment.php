<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleAssignmentRequest;
use App\Models\VehicleAssignment;
use Illuminate\Http\Request;

class VehicleAssignmentController extends Controller
{
    // Get all vehicle assignments
    public function getAllAssignments() {
        $assignments = VehicleAssignment::all();
        return response()->json($assignments);
    }

    // Create a new vehicle assignment
    public function createAssignment(VehicleAssignmentRequest $request) {
        try {
            $data = $request->validated();
            $assignment = VehicleAssignment::create($data);
            return response()->json(["message" => "Vehicle Assignment Successfully Created", "assignment" => $assignment], 201);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    // Get a specific vehicle assignment by ID
    public function getAssignmentById($id) {
        try {
            $assignment = VehicleAssignment::findOrFail($id);
            return response()->json($assignment);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 404);
        }
    }

    // Update a specific vehicle assignment by ID
    public function updateAssignment(VehicleAssignmentRequest $request, $id) {
        try {
            $assignment = VehicleAssignment::findOrFail($id);
            $assignment->update($request->validated());
            return response()->json(["message" => "Vehicle Assignment Updated Successfully", "assignment" => $assignment], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    // Delete a specific vehicle assignment by ID
    public function deleteAssignment($id) {
        try {
            $assignment = VehicleAssignment::findOrFail($id);
            $assignment->delete();
            return response()->json(["message" => "Vehicle Assignment Deleted Successfully"], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }
}
