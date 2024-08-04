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
        $dispatchlogs = DispatchLogs::all();
        return response()->json($dispatchlogs);
    }

    // Create a new dispatch log
    public function createDispatchLog(DispatchLogsStoreRequest $request) {
        try {
            $data = $request->validated();
            $data['created_by'] = Auth::id(); // Automatically set created_by
            $dispatchlog = DispatchLogs::create($data);
            return response()->json(["message" => "Dispatch Log Successfully Created", "dispatchlog" => $dispatchlog], 201);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    // Get a specific dispatch log by ID
    public function getDispatchLogById($id) {
        try {
            $dispatchlog = DispatchLogs::findOrFail($id);
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
            $dispatchlog->update($data);
            return response()->json(["message" => "Dispatch Log Updated Successfully", "log" => $dispatchlog], 200);
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
