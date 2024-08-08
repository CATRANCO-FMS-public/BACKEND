<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleAssignmentRequest;
use App\Models\VehicleAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            $data['created_by'] = Auth::id(); // Automatically set created_by
            $data['assignment_date'] = now(); // Automatically set assignment_date if not provided

            // Ensure assignment_date is set to now if not provided
            if (!isset($data['assignment_date'])) {
                $data['assignment_date'] = now();
            }

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
            $data = $request->validated();
            $data['updated_by'] = Auth::id(); // Automatically set updated_by
            $assignment->update($data);
            return response()->json(["message" => "Vehicle Assignment Updated Successfully", "assignment" => $assignment], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    // Update only the return date of a specific vehicle assignment by ID
    public function updateReturnDate(Request $request, $id) {
        try {
            $assignment = VehicleAssignment::findOrFail($id);
            $request->validate([
                'return_date' => 'required|date_format:Y-m-d H:i:s|after:assignment_date'
            ]);
            $data['return_date'] = $request->input('return_date');
            $data['updated_by'] = Auth::id(); // Automatically set updated_by
            $assignment->update($data);
            return response()->json(["message" => "Return Date Updated Successfully", "assignment" => $assignment], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    // Delete a specific vehicle assignment by ID
    public function deleteAssignment($id) {
        try {
            $assignment = VehicleAssignment::findOrFail($id);
            $assignment->deleted_by = Auth::id(); // Automatically set deleted_by
            $assignment->save();
            $assignment->delete();
            return response()->json(["message" => "Vehicle Assignment Deleted Successfully"], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }
}
