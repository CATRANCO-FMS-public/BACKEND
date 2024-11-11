<?php

namespace App\Http\Controllers;

use App\Models\OTP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

        return response()->json([
            'message' => 'OTP generated successfully',
            'otp' => $otpRecord->otp // Return OTP directly for testing; omit in production
        ]);
    }
}
