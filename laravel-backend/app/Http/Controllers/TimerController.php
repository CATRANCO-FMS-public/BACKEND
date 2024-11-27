<?php

namespace App\Http\Controllers;

use App\Models\Timer;
use App\Http\Requests\TimerRequest;

class TimerController extends Controller
{
    /**
     * Fetch all timers.
     */
    public function getAllTimers()
    {
        $timers = Timer::all();
        return response()->json([
            'message' => 'Timers fetched successfully.',
            'timers' => $timers,
        ], 200);
    }

    /**
     * Create a new timer.
     */
    public function createTimer(TimerRequest $request)
    {
        $timer = Timer::create($request->validated());

        return response()->json([
            'message' => 'Timer created successfully.',
            'timer' => $timer,
        ], 201);
    }

    /**
     * Fetch a specific timer by ID.
     */
    public function getTimerById($id)
    {
        $timer = Timer::findOrFail($id);

        return response()->json([
            'message' => 'Timer fetched successfully.',
            'timer' => $timer,
        ], 200);
    }

    /**
     * Update an existing timer by ID.
     */
    public function updateTimer(TimerRequest $request, $id)
    {
        $timer = Timer::findOrFail($id);
        $timer->update($request->validated());

        return response()->json([
            'message' => 'Timer updated successfully.',
            'timer' => $timer,
        ], 200);
    }

    /**
     * Delete a timer by ID.
     */
    public function deleteTimer($id)
    {
        $timer = Timer::findOrFail($id);
        $timer->delete();

        return response()->json([
            'message' => 'Timer deleted successfully.',
        ], 200);
    }
}
