<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    public function showLandingPage()
    {
    // Fetch users with user_type 'user'
    $users = User::where('user_type', 'user')->get(['name','member_code', 'email', 'user_type', 'id']);

    $sessionId = request()->query('session_id');

    // Get the currently authenticated user
    $loginUser = Auth::user();

    // Pass both sets of data to the view
    return view('auth.userLandingPage', compact('users', 'loginUser', 'sessionId'));

    }


    public function redirectToUserLandingPage()
    {
    // Fetch users with user_type 'user'
    $users = User::where('user_type', 'user')->get(['name','member_code', 'email', 'user_type', 'id']);

    $sessionId = request()->query('session_id');

    // Get the currently authenticated user
    $loginUser = Auth::user();

    // Pass both sets of data to the view
    // return view('auth.userLandingPage', compact('users', 'loginUser', 'sessionId'));
    $response = [
        'admins' => $admins,
        'users' => $users,
        'loginUser' => $loginUser,
        'sessionId' => $sessionId,
    ];

    // Return JSON response
    // return response()->json($response);

    // Assuming $response is an array or object with additional data
    $data = array_merge($response, compact('users', 'loginUser', 'sessionId'));

    // Prepare the data for the response
    // $data = compact('users', 'loginUser', 'sessionId');
    
    // Return the JSON response
    return response()->json($data);

    }

    public function showProfilePage()
    {
    // Fetch users with user_type 'user'
    $users = User::where('user_type', 'user')->get(['name','member_code', 'email', 'user_type', 'id']);

    $sessionId = request()->query('session_id');

    // Get the currently authenticated user
    $loginUser = Auth::user();

    // Pass both sets of data to the view
    return view('auth.userProfile', compact('users', 'loginUser', 'sessionId'));

    }


}
