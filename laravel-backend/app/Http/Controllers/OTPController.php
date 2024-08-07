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
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $otp = rand(100000, 999999);
        $expiresAt = now()->addMinutes(10); // OTP expires in 10 minutes

        OTP::create([
            'phone_number' => $request->phone_number,
            'otp' => $otp,
            'expires_at' => $expiresAt,
        ]);

        // Send OTP to user's phone number (Implement your SMS gateway here)

        return response()->json(['message' => 'OTP sent successfully']);
    }


    public function verifyOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string|max:20',
            'otp' => 'required|string|max:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $otpRecord = OTP::where('phone_number', $request->phone_number)
                        ->where('otp', $request->otp)
                        ->first();

        if ($otpRecord) {
            if ($otpRecord->is_verified) {
                return response()->json(['message' => 'OTP already verified'], 400);
            }

            if ($otpRecord->expires_at < now()) {
                return response()->json(['message' => 'OTP has expired'], 400);
            }

            $otpRecord->is_verified = true;
            $otpRecord->save();

            return response()->json(['message' => 'OTP verified successfully']);
        }

        return response()->json(['message' => 'Invalid OTP'], 400);
    }

    public function showOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $otpRecord = OTP::where('phone_number', $request->phone_number)->first();

        if ($otpRecord) {
            return response()->json(['otp' => $otpRecord->otp]);
        }

        return response()->json(['message' => 'OTP not found'], 404);
    }
}
