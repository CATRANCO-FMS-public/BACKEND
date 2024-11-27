<?php

namespace App\Http\Controllers;

use App\Http\Requests\DispatchRequest\DispatchStartRequest;
use App\Models\Dispatch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DispatchController extends Controller
{
    // Get all dispatches
    public function getAllDispatches()
    {
        $dispatches = Dispatch::with(['terminal', 'vehicleAssignments.userProfiles'])->get();
        return response()->json($dispatches);
    }

    // Start a new dispatch
    public function startDispatch(DispatchStartRequest $request)
    {
        try {
            $data = $request->validated();

            // Automatically set start_time to now
            $data['start_time'] = now();

            // Set default dispatch status
            $data['dispatch_status'] = 'on_road';

            // Automatically set created_by to the authenticated user's ID
            $data['created_by'] = Auth::id();

            // Create the dispatch
            $dispatch = Dispatch::create($data);

            return response()->json([
                'message' => 'Dispatch started successfully.',
                'dispatch' => $dispatch->load('terminal', 'vehicleAssignments.userProfiles'),
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Failed to start dispatch.',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    // Get a specific dispatch by ID
    public function getDispatchById($id)
    {
        try {
            $dispatch = Dispatch::with(['terminal', 'vehicleAssignments.userProfiles'])->findOrFail($id);
            return response()->json($dispatch);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 404);
        }
    }

    // Update a specific dispatch by ID
    public function updateDispatch(Request $request, $id)
    {
        try {
            $dispatch = Dispatch::findOrFail($id);
            $data = $request->all();
            $data['updated_by'] = Auth::id(); // Automatically set updated_by
            $dispatch->update($data);

            return response()->json([
                "message" => "Dispatch Updated Successfully",
                "dispatch" => $dispatch->load('terminal', 'vehicleAssignments.userProfiles'),
            ], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    // End a specific dispatch by ID
    public function endDispatch($id)
    {
        try {
            $dispatch = Dispatch::findOrFail($id);

            // Set end_time and mark as completed
            $dispatch->end_time = now();
            $dispatch->dispatch_status = 'completed';
            $dispatch->save();

            return response()->json([
                "message" => "Dispatch Ended Successfully",
                "dispatch" => $dispatch->load('terminal', 'vehicleAssignments.userProfiles'),
            ], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    // Cancel a specific dispatch by ID
    public function cancelDispatch($id)
    {
        try {
            $dispatch = Dispatch::findOrFail($id);

            // Set end_time and mark as cancelled
            $dispatch->end_time = now();
            $dispatch->dispatch_status = 'cancelled';
            $dispatch->save();

            return response()->json([
                "message" => "Dispatch Cancelled Successfully",
                "dispatch" => $dispatch->load('terminal', 'vehicleAssignments.userProfiles'),
            ], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }
}
