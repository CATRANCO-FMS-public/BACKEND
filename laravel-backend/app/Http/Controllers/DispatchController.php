<?php

namespace App\Http\Controllers;

use App\Http\Requests\DispatchStoreRequest;
use App\Models\Dispatch;
use Illuminate\Http\Request;

class DispatchController extends Controller
{
    // Get all dispatches
    public function getAllDispatches() {
        $dispatches = Dispatch::all();
        return response()->json($dispatches);
    }

    // Start a new dispatch
    public function startDispatch(DispatchStoreRequest $request) {
        try {
            $data = $request->validated();
            $data['start_time'] = now();
            $data['dispatch_status'] = 'in_progress';
            $dispatch = Dispatch::create($data);
            return response()->json(["message" => "Dispatch Started Successfully", "dispatch" => $dispatch], 201);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    // Get a specific dispatch by ID
    public function getDispatchById($id) {
        try {
            $dispatch = Dispatch::findOrFail($id);
            return response()->json($dispatch);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 404);
        }
    }

    // Update a specific dispatch by ID
    public function updateDispatch(DispatchStoreRequest $request, $id) {
        try {
            $dispatch = Dispatch::findOrFail($id);
            $data = $request->validated();
            $dispatch->update($data);
            return response()->json(["message" => "Dispatch Updated Successfully", "dispatch" => $dispatch], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    // Delete a specific dispatch by ID
    public function deleteDispatch($id) {
        try {
            $dispatch = Dispatch::findOrFail($id);
            $dispatch->delete();
            return response()->json(["message" => "Dispatch Deleted Successfully"], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    // End a specific dispatch by ID
    public function endDispatch($id) {
        try {
            $dispatch = Dispatch::findOrFail($id);
            $dispatch->end_time = now();
            $dispatch->dispatch_status = 'completed';
            $dispatch->save();
            return response()->json(["message" => "Dispatch Ended Successfully", "dispatch" => $dispatch], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    // Cancel a specific dispatch by ID
    public function cancelDispatch($id) {
        try {
            $dispatch = Dispatch::findOrFail($id);
            $dispatch->end_time = now();
            $dispatch->dispatch_status = 'cancelled';
            $dispatch->save();
            return response()->json(["message" => "Dispatch Cancelled Successfully", "dispatch" => $dispatch], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }
}
