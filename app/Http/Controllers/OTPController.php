<?php

namespace App\Http\Controllers;

use App\Models\OTP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class OTPController extends Controller
{
    public function generateOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string|max:20',
            'feedback_logs_id' => 'required|exists:feedback_logs,feedback_logs_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Reset previous OTPs for this feedback log
        OTP::where('phone_number', $request->phone_number)
            ->where('feedback_logs_id', $request->feedback_logs_id)
            ->update(['is_verified' => false]);

        $otp = rand(100000, 999999);
        $expiresAt = now()->addMinutes(10);

        $otpRecord = OTP::create([
            'phone_number' => $request->phone_number,
            'otp' => $otp,
            'expires_at' => $expiresAt,
            'feedback_logs_id' => $request->feedback_logs_id,
        ]);

        // Send OTP via Twilio
        $this->sendOtpWithTwilio($request->phone_number, $otp);

        return response()->json([
            'message' => 'OTP generated successfully',
            'otp' => $otpRecord->otp // Return OTP directly for testing; omit in production
        ]);
    }

    private function formatPhoneNumber($phoneNumber)
    {
        // Ensure the phone number starts with +63 if it's a Philippine number
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '+63' . substr($phoneNumber, 1);
        }
        return $phoneNumber;
    }


    private function sendOtpWithTwilio($phone_number, $otp)
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
        $twilioPhoneNumber = env('TWILIO_PHONE');

        // Log the variables for debugging
        Log::info("Twilio SID: $sid, Token: $token, Phone Number: $twilioPhoneNumber");

        $client = new Client($sid, $token);

        // Format the phone number to E.164 format
        $formattedPhoneNumber = $this->formatPhoneNumber($phone_number);

        try {
            $client->messages->create(
                $formattedPhoneNumber,
                [
                    'from' => $twilioPhoneNumber,
                    'body' => "Your OTP code is: {$otp}"
                ]
            );
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Twilio Error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to send OTP.'], 500);
        }
    }

}
