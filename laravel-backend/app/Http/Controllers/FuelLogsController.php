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
        $fuelLogs = FuelLogs::all()->map(function($fuelLog) {
            // Format the price and total cost
            $fuelLog->fuel_price = '₱' . number_format($fuelLog->fuel_price, 2);
            $fuelLog->total_cost = '₱' . number_format($fuelLog->total_cost, 2);
            return $fuelLog;
        });
        
        return response()->json($fuelLogs);
    }

    // Create a new fuel log
    public function createFuelLog(FuelLogsStoreRequest $request) {
        try {
            $data = $request->validated();
            $data['created_by'] = Auth::id(); // Automatically set created_by

            // Calculate total_cost
            $data['total_cost'] = $data['fuel_quantity'] * $data['fuel_price'];

            $fuelLog = FuelLogs::create($data);
            // Format the price and total cost for response
            $fuelLog->fuel_price = '₱' . number_format($fuelLog->fuel_price, 2);
            $fuelLog->total_cost = '₱' . number_format($fuelLog->total_cost, 2);

            return response()->json(["message" => "Fuel Log Successfully Created", "fuel_log" => $fuelLog], 201);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    // Get a specific fuel log by ID
    public function getFuelLogById($id) {
        try {
            $fuelLog = FuelLogs::findOrFail($id);
            // Format the price and total cost
            $fuelLog->fuel_price = '₱' . number_format($fuelLog->fuel_price, 2);
            $fuelLog->total_cost = '₱' . number_format($fuelLog->total_cost, 2);

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
            
            // Calculate total_cost
            $data['total_cost'] = $data['fuel_quantity'] * $data['fuel_price'];

            $fuelLog->update($data);
            // Format the price and total cost for response
            $fuelLog->fuel_price = '₱' . number_format($fuelLog->fuel_price, 2);
            $fuelLog->total_cost = '₱' . number_format($fuelLog->total_cost, 2);

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
            $fuelLog->save(); // Save the deleted_by field
            $fuelLog->delete(); // Then delete the record

            return response()->json(["message" => "Fuel Log Deleted Successfully"], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }
}