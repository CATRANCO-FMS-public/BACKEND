<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleStoreRequest;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    // Get all vehicles
    public function getAllVehicles() {
        $vehicles = Vehicle::all();

        return response()->json($vehicles);
    }

    // Create a new vehicle
    public function createVehicle(VehicleStoreRequest $request) {
        try {
            $data = $request->validated();
            $vehicle = Vehicle::create($data);
            return response()->json(["message" => "Vehicle Successfully Created", "vehicle" => $vehicle], 201);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    // Get a specific vehicle by ID
    public function getVehicleById($id) {
        try {
            $vehicle = Vehicle::findOrFail($id);
            return response()->json($vehicle);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 404);
        }
    }

    // Update a specific vehicle by ID
    public function updateVehicle(VehicleStoreRequest $request, $id) {
        try {
            $vehicle = Vehicle::findOrFail($id);
            $vehicle->update($request->validated());
            return response()->json(["message" => "Vehicle Updated Successfully", "vehicle" => $vehicle], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    // Delete a specific vehicle by ID
    public function deleteVehicle($id) {
        try {
            $vehicle = Vehicle::findOrFail($id);
            $vehicle->delete();
            return response()->json(["message" => "Vehicle Deleted Successfully"], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }
}
