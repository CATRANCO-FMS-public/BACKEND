<?php

namespace App\Http\Controllers;

use App\Http\Requests\DispatchRequest\AlleyStartRequest;
use App\Http\Requests\DispatchRequest\DispatchStartRequest;
use App\Http\Requests\DispatchRequest\DeleteDispatchRequest;
use App\Models\DispatchLogs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DispatchLogsController extends Controller
{
    // Get all dispatches
    public function getAllDispatches()
    {
        $dispatches = DispatchLogs::with(['vehicleAssignments.vehicle.trackerMapping','createdDispatch','updatedDispatch','deletedDispatch','vehicleAssignments.userProfiles'])->get();
        return response()->json($dispatches);
    }

    // Start a new alley
    public function startAlley(AlleyStartRequest $request)
    {
        try {
            $data = $request->validated();

            // Check if the vehicle_assignment_id is already on alley
            $existingAlley = DispatchLogs::where('vehicle_assignment_id', $data['vehicle_assignment_id'])
                ->where('status', 'on alley')
                ->first();

            if ($existingAlley) {
                return response()->json([
                    'error' => 'The selected vehicle assignment is already on alley.',
                ], 400);
            }

            // Automatically set start_time to now
            $data['start_time'] = now();

            // Set default dispatch status
            $data['status'] = 'on alley';

            // Automatically set created_by to the authenticated user's ID
            $data['created_by'] = Auth::id();

            // Create the dispatch
            $dispatch = DispatchLogs::create($data);

            return response()->json([
                'message' => 'Alley started successfully.',
                'dispatch' => $dispatch->load('vehicleAssignments.userProfiles'),
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Failed to start alley.',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    // Start a new dispatch
    public function startDispatch(DispatchStartRequest $request)
    {
        try {
            $data = $request->validated();

            // Check if the vehicle_assignment_id is already on road
            $existingAlley = DispatchLogs::where('vehicle_assignment_id', $data['vehicle_assignment_id'])
                ->where('status', 'on road')
                ->first();

            if ($existingAlley) {
                return response()->json([
                    'error' => 'The selected bus is already on road.',
                ], 400);
            }

            // Automatically set start_time to now
            $data['start_time'] = now();

            // Set default dispatch status
            $data['status'] = 'on road';

            // Automatically set created_by to the authenticated user's ID
            $data['created_by'] = Auth::id();

            // Create the dispatch
            $dispatch = DispatchLogs::create($data);

            return response()->json([
                'message' => 'Dispatch started successfully.',
                'dispatch' => $dispatch->load( 'vehicleAssignments.userProfiles'),
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
            $dispatch = DispatchLogs::with(['vehicleAssignments.userProfiles'])->findOrFail($id);
            return response()->json($dispatch);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 404);
        }
    }

    // End a specific alley by ID
    public function endAlley($id)
    {
        try {
            $dispatch = DispatchLogs::findOrFail($id);

            // Check if already marked as completed
            if ($dispatch->status === 'alley_completed' || $dispatch->status === 'dispatch_completed') {
                return response()->json([
                    "error" => "This record has already been marked as completed and cannot be updated."
                ], 400);
            }

            // Set end_time and mark as completed
            $dispatch->end_time = now();
            $dispatch['updated_by'] = Auth::id();
            $dispatch->status = 'alley_completed';
            $dispatch->save();

            return response()->json([
                "message" => "Alley Ended Successfully",
                "alley" => $dispatch->load('vehicleAssignments.userProfiles'),
            ], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    // End a specific dispatch by ID
    public function endDispatch($id)
    {
        try {
            $dispatch = DispatchLogs::findOrFail($id);

            // Check if already marked as completed
            if ($dispatch->status === 'dispatch_completed' || $dispatch->status === 'alley_completed') {
                return response()->json([
                    "error" => "This record has already been marked as completed and cannot be updated."
                ], 400);
            }

            // Set end_time and mark as completed
            $dispatch->end_time = now();
            $dispatch->status = 'dispatch_completed';
            $dispatch->save();

            return response()->json([
                "message" => "Dispatch Ended Successfully",
                "dispatch" => $dispatch->load('vehicleAssignments.userProfiles'),
            ], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    public function deleteRecords(DeleteDispatchRequest $request)
    {
        try {
            // The validated data is automatically available in $request
            $ids = $request->validated()['ids'];

            // Optionally check business logic before deletion
            $dispatches = DispatchLogs::whereIn('dispatch_logs_id', $ids)->get();
            foreach ($dispatches as $dispatch_logs) {
                if ($dispatch_logs->status === 'completed') {
                    return response()->json([
                        'error' => 'Cannot delete a completed dispatch.',
                        'dispatch_logs_id' => $dispatch_logs->dispatch_logs_id,
                    ], 400);
                }
            }

            // Perform the deletion
            $deletedCount = DispatchLogs::whereIn('dispatch_logs_id', $ids)->delete();

            return response()->json([
                'message' => $deletedCount === 1 
                    ? 'Dispatch record deleted successfully.' 
                    : 'Dispatch records deleted successfully.',
                'deleted_ids' => $ids,
            ], status: 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete records.',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function tripsToday()
    {
        // Get today's date in a format suitable for the query (YYYY-MM-DD)
        $today = Carbon::today()->toDateString(); // Ensures today's date in the correct format
        
        // Count the number of completed dispatch logs for today
        $count = DispatchLogs::where('status', 'dispatch_completed')
            ->whereDate('end_time', $today) // Filters by today's date
            ->count(); // Get the count of records

        // Return the result as a JSON response
        return response()->json(['trips_today' => $count]);
    }

    // Get all dispatches that are "on alley"
    public function getAllOnAlley()
    {
        try {
            $onAlleyDispatches = DispatchLogs::with(['vehicleAssignments.vehicle.trackerMapping', 'createdDispatch', 'updatedDispatch', 'deletedDispatch', 'vehicleAssignments.userProfiles'])
                ->where('status', 'on alley')
                ->get();

            return response()->json($onAlleyDispatches, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch dispatches on alley.',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    // Get all dispatches that are "on road"
    public function getAllOnRoad()
    {
        try {
            $onRoadDispatches = DispatchLogs::with(['vehicleAssignments.vehicle.trackerMapping', 'createdDispatch', 'updatedDispatch', 'deletedDispatch', 'vehicleAssignments.userProfiles'])
                ->where('status', 'on road')
                ->get();

            return response()->json($onRoadDispatches, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch dispatches on road.',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

}
