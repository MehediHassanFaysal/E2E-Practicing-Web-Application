<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        // Validate email
        $request->validate(['email' => 'required|email']);

        // Generate OTP and expiration time
        $otp = rand(100000, 999999);
        $expirationTime = now()->addMinutes(5);
        
        // Store OTP and expiration in session
        Session::put('otp', $otp);
        Session::put('otp_expires_at', $expirationTime);

        // Here, send the OTP via email (implement email sending logic)

        return response()->json(['message' => 'OTP sent successfully']);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $otp = Session::get('otp');
        $expiresAt = Session::get('otp_expires_at');

        if (now()->greaterThan($expiresAt)) {
            return response()->json(['message' => 'OTP has expired'], 400);
        }

        if ($request->otp == $otp) {
            return response()->json(['message' => 'OTP verified successfully']);
        } else {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }
    }
}
