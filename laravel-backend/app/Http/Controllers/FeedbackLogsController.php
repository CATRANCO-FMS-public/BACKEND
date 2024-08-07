<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackLogsStoreRequest;
use App\Models\FeedbackLogs;
use App\Models\OTP;
use Illuminate\Http\Request;

class FeedbackLogsController extends Controller
{
    // Create a new feedback log
    public function createFeedbackLog(FeedbackLogsStoreRequest $request)
    {
        // Extract phone number and OTP
        $phone_number = $request->input('phone_number');

        // Check for verified OTP
        $otpRecord = OTP::where('phone_number', $phone_number)
                        ->where('is_verified', true)
                        ->first();

        if (!$otpRecord) {
            return response()->json(['message' => 'Phone number not verified'], 403);
        }

        // Prepare and validate data
        $data = $request->validated();
        $data['created_date'] = now(); // Automatically set created_date

        // Try to create feedback log
        try {
            $feedbackLog = FeedbackLogs::create($data);
            return response()->json(["message" => "Feedback Successfully Submitted", "feedback" => $feedbackLog], 201);
        } catch (\Exception $e) {
            // Log the error or output it for debugging
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    // Get all feedback logs (admin only)
    public function getAllFeedbackLogs()
    {
        $feedbackLogs = FeedbackLogs::with('vehicle')->get();
        return response()->json($feedbackLogs);
    }

    // Get a specific feedback log by ID (admin only)
    public function getFeedbackLogById($id)
    {
        try {
            $feedbackLog = FeedbackLogs::with('vehicle')->findOrFail($id);
            return response()->json($feedbackLog);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 404);
        }
    }

    // Delete a specific feedback log by ID (admin only)
    public function deleteFeedbackLog($id)
    {
        try {
            $feedbackLog = FeedbackLogs::findOrFail($id);
            $feedbackLog->delete();
            return response()->json(["message" => "Feedback Log Deleted Successfully"], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }
}
