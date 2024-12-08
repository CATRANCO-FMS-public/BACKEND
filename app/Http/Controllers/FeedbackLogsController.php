<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackLogsStoreRequest;
use App\Models\FeedbackLogs;
use App\Models\OTP;
use Illuminate\Http\Request;

class FeedbackLogsController extends Controller
{
    public function createFeedbackLog(FeedbackLogsStoreRequest $request)
    {
        // Step 1: Validate and retrieve data without requiring phone number
        $data = $request->validated();

        try {
            // Step 2: Check if there's any existing feedback log with a null phone number
            $existingFeedbackLog = FeedbackLogs::whereNull('phone_number')->first();

            if ($existingFeedbackLog) {
                return response()->json(["message" => "A feedback log is already pending phone number verification."], 403);
            }

            // Step 3: Create a new feedback log if no log with a null phone number exists
            $feedbackLog = FeedbackLogs::create($data);

            return response()->json([
                "message" => "Feedback partially submitted. Please enter your phone number to verify.",
                "feedback_logs_id" => $feedbackLog->feedback_logs_id
            ], 201);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    public function verifyPhoneNumber(Request $request, $feedback_logs_id)
    {
        $request->validate([
            'phone_number' => 'required|string|max:20',
            'otp' => 'required|string|max:6',
        ]);

        $feedbackLog = FeedbackLogs::findOrFail($feedback_logs_id);

        // Check OTP without requiring `is_verified` to be `true`
        $otpRecord = $feedbackLog->otp()
                                ->where('phone_number', $request->input('phone_number'))
                                ->where('otp', $request->input('otp'))
                                ->where('expires_at', '>', now())
                                ->first();

        if (!$otpRecord) {
            return response()->json(['message' => 'Invalid OTP or OTP has expired'], 403);
        }

        // Mark the OTP as verified
        $otpRecord->update(['is_verified' => true]);

        // Update the feedback log with the verified phone number
        $feedbackLog->phone_number = $request->input('phone_number');
        $feedbackLog->save();

        return response()->json(["message" => "Feedback fully submitted", "feedback" => $feedbackLog], 200);
    }


    public function getAllFeedbackLogs(Request $request)
    {
        try {
            // Fetch all feedback logs, including optional filters if provided
            $feedbackLogs = FeedbackLogs::query();

            // Optional: Filter by phone number (if provided in the query string)
            if ($request->has('phone_number')) {
                $feedbackLogs->where('phone_number', $request->input('phone_number'));
            }

            // Fetch the results (paginate if necessary)
            $feedbackLogs = $feedbackLogs->get();

            return response()->json(['data' => $feedbackLogs], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function getFeedbackLogById($id)
    {
        try {
            // Find the feedback log by ID
            $feedbackLog = FeedbackLogs::find($id);

            if (!$feedbackLog) {
                return response()->json(['message' => 'Feedback log not found'], 404);
            }

            return response()->json(['data' => $feedbackLog], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function deleteFeedbackLog($id)
    {
        try {
            // Find the feedback log by ID
            $feedbackLog = FeedbackLogs::find($id);

            if (!$feedbackLog) {
                return response()->json(['message' => 'Feedback log not found'], 404);
            }

            // Delete the feedback log
            $feedbackLog->delete();

            return response()->json(['message' => 'Feedback log successfully deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }


}
