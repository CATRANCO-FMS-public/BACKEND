<?php

namespace App\Http\Controllers;

use App\Http\Requests\FuelLogsStoreRequest;
use App\Models\FuelLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FuelLogsController extends Controller
{
    // Get all fuel logs
    public function getAllFuelLogs() {
        $fuelLogs = FuelLogs::all();
        return response()->json($fuelLogs);
    }

    // Create a new fuel log
    public function createFuelLog(FuelLogsStoreRequest $request) {
        try {
            $data = $request->validated();
            $data['created_by'] = Auth::id(); // Automatically set created_by
            $fuelLog = FuelLogs::create($data);
            return response()->json(["message" => "Fuel Log Successfully Created", "fuel_log" => $fuelLog], 201);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    // Get a specific fuel log by ID
    public function getFuelLogById($id) {
        try {
            $fuelLog = FuelLogs::findOrFail($id);
            return response()->json($fuelLog);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 404);
        }
    }

    // Update a specific fuel log by ID
    public function updateFuelLog(FuelLogsStoreRequest $request, $id) {
        try {
            $fuelLog = FuelLogs::findOrFail($id);
            $data = $request->validated();
            $data['updated_by'] = Auth::id(); // Automatically set updated_by
            $fuelLog->update($data);
            return response()->json(["message" => "Fuel Log Updated Successfully", "fuel_log" => $fuelLog], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    // Delete a specific fuel log by ID
    public function deleteFuelLog($id) {
        try {
            $fuelLog = FuelLogs::findOrFail($id);
            $fuelLog->deleted_by = Auth::id(); // Automatically set deleted_by
            $fuelLog->save();
            $fuelLog->delete();
            return response()->json(["message" => "Fuel Log Deleted Successfully"], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }
}