<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|regex:/^[\pL][\pL\- .]*$/u',
            'email' => 'required|string|email|max:255', // email validation
            // 'email' => 'required|string|email|max:255|unique:users', // email validation
            'password' => [
                'required',
                'string',
                'min:6',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/',
                'confirmed',
            ],
            'password_confirmation' => 'required|string|min:6',
            'user_type' => 'required|string',
            // 'user_type' => 'required|string|in:admin,user',
        ]);
    
        // Check for validation failures
        if ($validator->fails()) {
            // Return 422 for validation errors
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Check for existing email
        if (User::where('email', $request->email)->exists()) {
            // Return 409 Conflict if email already exists
            return response()->json(['error' => 'Email already exists in the system.'], 409);
        }
        // Additional condition for 400 Bad Request
        if (empty($request->user_type) || !in_array($request->user_type, ['admin', 'user'])) {
            // Return 400 Bad Request if user_type is invalid
            return response()->json(['error' => 'Invalid user type.'], 400);
        }
    
        // Generate the member code
        $memberCode = User::generateMemberCode();
    
        // Create a new user
        $user = User::create([
            'member_code' => $memberCode,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
        ]);
    
        // Return a response
        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
        ], 201);
    }
    
}

