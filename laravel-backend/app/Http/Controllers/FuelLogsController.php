<?php

namespace App\Http\Controllers;

use App\Http\Requests\FuelLogsStoreRequest;
use App\Models\FuelLogs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FuelLogsController extends Controller
{
    // Get all fuel logs
    public function getAllFuelLogs()
    {
        $fuelLogs = FuelLogs::all()->map(function ($fuelLog) {
            // Format the price and total expense
            $fuelLog->fuel_price = '₱' . number_format($fuelLog->fuel_price, 2);
            $fuelLog->total_expense = '₱' . number_format($fuelLog->total_expense, 2);
            return $fuelLog;
        });

        return response()->json($fuelLogs);
    }

    // Create a new fuel log
    public function createFuelLog(FuelLogsStoreRequest $request)
    {
        try {
            // Log the raw input for debugging
            Log::info('Raw Input:', $request->all());

            // Check if Laravel recognizes file inputs
            if ($request->hasFile('odometer_distance_proof')) {
                Log::info('Odometer Proof Uploaded:', [$request->file('odometer_distance_proof')]);
            } else {
                Log::warning('Odometer Proof NOT Uploaded.');
            }

            if ($request->hasFile('fuel_receipt_proof')) {
                Log::info('Fuel Receipt Proof Uploaded:', [$request->file('fuel_receipt_proof')]);
            } else {
                Log::warning('Fuel Receipt Proof NOT Uploaded.');
            }

            // Check all request fields
            Log::info('Request Data:', $request->all());

            $data = $request->validated();
            $data['created_by'] = Auth::id(); // Automatically set created_by

            // Retrieve the previous odometer reading for the same vehicle
            $previousLog = FuelLogs::where('vehicle_id', $data['vehicle_id'])
                ->orderBy('purchase_date', 'desc')
                ->first();

            // Calculate distance_traveled
            $data['distance_traveled'] = $previousLog
                ? $data['odometer_km'] - $previousLog->odometer_km
                : 0;

            // Handle odometer distance proof file upload
            if ($request->hasFile('odometer_distance_proof')) {
                $odometerProofPath = $request->file('odometer_distance_proof')->store('fuel_logs', 'public');
                $data['odometer_distance_proof'] = $odometerProofPath;
            }

            // Handle fuel receipt proof file upload
            if ($request->hasFile('fuel_receipt_proof')) {
                $receiptProofPath = $request->file('fuel_receipt_proof')->store('fuel_logs', 'public');
                $data['fuel_receipt_proof'] = $receiptProofPath;
            }

            // Calculate total expense
            $data['total_expense'] = $data['fuel_liters_quantity'] * $data['fuel_price'];

            // Create a new fuel log
            $fuelLog = FuelLogs::create($data);

            // Format the price and total expense for response
            $fuelLog->fuel_price = '₱' . number_format($fuelLog->fuel_price, 2);
            $fuelLog->total_expense = '₱' . number_format($fuelLog->total_expense, 2);

            return response()->json(["message" => "Fuel Log Successfully Created", "fuel_log" => $fuelLog], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }


    // Get a specific fuel log by ID
    public function getFuelLogById($id)
    {
        try {
            $fuelLog = FuelLogs::findOrFail($id);
            // Format the price and total expense
            $fuelLog->fuel_price = '₱' . number_format($fuelLog->fuel_price, 2);
            $fuelLog->total_expense = '₱' . number_format($fuelLog->total_expense, 2);

            return response()->json($fuelLog);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 404);
        }
    }

    // Update a specific fuel log by ID
    public function updateFuelLog(FuelLogsStoreRequest $request, $id)
    {
        try {
            $fuelLog = FuelLogs::findOrFail($id);
            $data = $request->validated();
            $data['updated_by'] = Auth::id(); // Automatically set updated_by

            // Handle odometer distance proof file upload
            if ($request->hasFile('odometer_distance_proof')) {
                // Delete the old file if it exists
                if ($fuelLog->odometer_distance_proof) {
                    Storage::disk('public')->delete($fuelLog->odometer_distance_proof);
                }

                // Store the new file
                $odometerProofPath = $request->file('odometer_distance_proof')->store('fuel_logs', 'public');
                $data['odometer_distance_proof'] = $odometerProofPath;
            }

            // Handle fuel receipt proof file upload
            if ($request->hasFile('fuel_receipt_proof')) {
                // Delete the old file if it exists
                if ($fuelLog->fuel_receipt_proof) {
                    Storage::disk('public')->delete($fuelLog->fuel_receipt_proof);
                }

                // Store the new file
                $receiptProofPath = $request->file('fuel_receipt_proof')->store('fuel_logs', 'public');
                $data['fuel_receipt_proof'] = $receiptProofPath;
            }

            // Calculate total expense
            $data['total_expense'] = $data['fuel_liters_quantity'] * $data['fuel_price'];

            // Update the fuel log
            $fuelLog->update($data);

            // Format the price and total expense for response
            $fuelLog->fuel_price = '₱' . number_format($fuelLog->fuel_price, 2);
            $fuelLog->total_expense = '₱' . number_format($fuelLog->total_expense, 2);

            return response()->json([
                "message" => "Fuel Log Updated Successfully",
                "fuel_log" => $fuelLog,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    // Delete a specific fuel log by ID
    public function deleteFuelLog($id)
    {
        try {
            $fuelLog = FuelLogs::findOrFail($id);

            // Delete the associated files if they exist
            if ($fuelLog->odometer_distance_proof) {
                Storage::disk('public')->delete($fuelLog->odometer_distance_proof);
            }

            if ($fuelLog->fuel_receipt_proof) {
                Storage::disk('public')->delete($fuelLog->fuel_receipt_proof);
            }

            // Mark the log as deleted and save the user who deleted it
            $fuelLog->deleted_by = Auth::id(); // Automatically set deleted_by
            $fuelLog->save(); // Save the deleted_by field

            // Delete the record from the database
            $fuelLog->delete();

            return response()->json(["message" => "Fuel Log and Associated Files Deleted Successfully"], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

}
