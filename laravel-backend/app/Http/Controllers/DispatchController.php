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

    // Create a new dispatch
    public function createDispatch(DispatchStoreRequest $request) {
        try {
            $data = $request->validated();
            $dispatch = Dispatch::create($data);
            return response()->json(["message" => "Dispatch Successfully Created", "dispatch" => $dispatch], 201);
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
}
