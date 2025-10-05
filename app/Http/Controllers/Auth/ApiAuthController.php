<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;


class ApiAuthController extends Controller
{

     /**
     * Handle user logout and token invalidation.
     *
     * @param Request $request
     * @return JsonResponse
     */

     public function login(Request $request): JsonResponse
     {
         // Validate incoming request data
         $validator = Validator::make($request->all(), [
             'email' => 'required|email',
             'password' => 'required',
             'user_type' => 'required',
         ]);

    // Check if JSON decoding failed
    if (json_last_error() !== JSON_ERROR_NONE) {
        return response()->json(['error' => 'Malformed JSON. Please check your request.'], 400);
    }
    if (empty($request->email) && empty($request->password) && empty($request->user_type)) {
        return response()->json(['error' => 'Email, Password and user type are required.'], 400);
    }
    if (empty($request->password) && empty($request->user_type)) {
        return response()->json(['error' => 'Password and user type are required.'], 400);
    }
    if (empty($request->email) && empty($request->user_type)) {
        return response()->json(['error' => 'Email and user type are required.'], 400);
    }
    if (empty($request->email) && empty($request->password)) {
        return response()->json(['error' => 'Email and password are required.'], 400);
    }
    if (empty($request->user_type)) {
        return response()->json(['error' => 'User type required.'], 400);
    }
    if (empty($request->password)) {
        return response()->json(['error' => 'Password required.'], 400);
    }
    if (empty($request->email)) {
        return response()->json(['error' => 'Email Address required.'], 400);
    }

         if ($validator->fails()) {
             return response()->json(['errors' => $validator->errors()], 422);
         }
     
         // Check credentials
         $credentials = $request->only('email', 'password', 'user_type');
         
         if (!Auth::attempt($credentials)) {
             return response()->json(['error' => 'Unauthorized'], 401);
         }
     
         // Get the authenticated user
         $user = Auth::user();
         if (!$user) {
             return response()->json(['error' => 'User not found'], 404);
         }
         // Create a token for the authenticated user
         try {
             $token = $user->createToken('testWebApplication@6543210', ['view-users'])->plainTextToken;
             $token = substr($token, strpos($token, '|') + 1);
            } catch (\Exception $e) {
             return response()->json(['error' => 'Token creation failed', 'message' => $e->getMessage()], 500);
         }
     
         // Return response
         return response()->json([
             'user_info' => [
                 'member_code' => $user->member_code,
                 'name' => $user->name,
                 'email' => $user->email,
                 'user_type' => $user->user_type,
             ],
             'token' => $token,
             'session_id' => session()->getId(),
         ]);
     }
     
     
     
    public function logout(Request $request): JsonResponse
    {
        // Revoke the current user's API tokens
        $user = Auth::user();
        if ($user) {
            // Delete all tokens for the user
            $user->tokens()->delete();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out successfully']);
    }

    /**
     * Return all user data.
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function index(Request $request): JsonResponse
    {


        // $users = User::all(); // Fetch all users
        // return response()->json($users);
        
            // Get the authenticated user
            $user = $request->user();
        
            // Check if the user is authenticated
            if (!$user) {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }
            
            // Check if the user has the necessary permissions
            if ($user->tokenCan('view-users')) {
                $users = User::all();
                return response()->json([
                    'message' => 'Successful',
                    'user_info' => $users
                ]);
            }
        
            // Return unauthorized response if user lacks permission
            return response()->json(['error' => 'Unauthenticated'], 403);
    }



    public function fetchAdminInfo()
    {
    $loginUser = Auth::user();
    $sessionId = request()->query('session_id');

    // Fetch users with user_type 'admin'
    $admins = User::where('user_type', 'admin')->get(['name','member_code', 'email', 'user_type', 'id']);
    $users = User::where('user_type', 'user')->get(['name','member_code', 'email', 'user_type', 'id']);

    // Pass both sets of data to the view
    return view('auth.landingPage', compact('admins', 'users', 'loginUser', 'sessionId'));

    }

    public function getAdminInfo(): JsonResponse
    {
        // Fetch users with user_type 'admin' only
        $users = User::where('user_type', 'admin')->get(['name', 'email', 'user_type']);

        // Convert the collection to an array and format it for JSON response
        $userArray = $users->map(function ($user) {
            return [
                'name' => $user->name,
                'email' => $user->email,
                'user_type' => $user->user_type,
            ];
        });

        // Return the JSON response
        return response()->json([
            'message' => 'Successful',
            'admin_info' => $userArray,
        ]);
    }
    public function getUserInfo(): JsonResponse
    {
        // Fetch users with user_type 'admin' only
        $users = User::where('user_type', 'user')->get(['name', 'email', 'user_type']);

        // Convert the collection to an array and format it for JSON response
        $userArray = $users->map(function ($user) {
            return [
                'name' => $user->name,
                'email' => $user->email,
                'user_type' => $user->user_type,
            ];
        });

        // Return the JSON response
        return response()->json([
            'message' => 'Successful',
            'user_info' => $userArray,
        ]);
    }

    // Show the form for editing a user
    public function edit($id)
    {
        $admin = User::findOrFail($id); // Retrieve the user or fail
        // $sessionId = request()->query('session_id');
        $sessionId = session()->getId();
        // Get the currently authenticated user
        $loginUser = Auth::user();
        $admins = User::where('user_type', 'admin')->get(['name','member_code', 'email', 'user_type', 'id']);
        $users = User::where('user_type', 'user')->get(['name','member_code', 'email', 'user_type', 'id']);
        
        return view('auth.landingPage', compact('admin', 'sessionId', 'loginUser', 'admins', 'users')); // Pass user to the view
    }
    public function editUser($id)
    {
        $user = User::findOrFail($id); // Retrieve the user or fail
        $sessionId = session()->getId();

        $response = [
            'admin_info' => $user,
            'session_id' => $sessionId
        ];
    
        // Return JSON response
        // return response()->json($response);
    
        // Assuming $response is an array or object with additional data
        // $data = array_merge($response, compact('user','sessionId'));
    
        // Prepare the data for the response
        // $data = compact('users', 'sessionId');
        
        // Return the JSON response
        return response()->json($response);
    }

    // Update the user in the database
    public function update(Request $request, $id)
    {
        // Find the user or fail
        $user = User::findOrFail($id);

        // Define validation rules
        $validationRules = [
            'name' => 'required|string|max:100|regex:/^[\pL][\pL\- .]*$/u',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                // Rule::unique('users')->ignore($user->id), // Ignore the current user's email during validation
            ],
            'user_type' => 'required|string|in:admin,user',
        ];

        // Validate the request data
        $request->validate($validationRules);

        // Update user with request data
        $user->update($request->only(['name', 'email', 'user_type'])); // Use only the fields that are being updated

        // Fetch users with user_type 'admin'
        $admins = User::where('user_type', 'admin')->get(['name', 'email', 'user_type', 'id']);
        $users = User::where('user_type', 'user')->get(['name', 'email', 'user_type', 'id']);

        $sessionId = session()->getId();

        // Get the currently authenticated user
        $loginUser = Auth::user();

        // Pass both sets of data to the view
        return view('auth.landingPage', compact('admins', 'users', 'loginUser', 'sessionId'));
    }

    public function updateUser(Request $request, $id)
    {
        // Ensure the user is authenticated using Bearer token
        $user = Auth::user(); // Get the authenticated user

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Validate the request data
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:100|regex:/^[\pL][\pL\- .]*$/u',
                'email' => 'required|string|email|max:255|unique:users,email',
                'user_type' => 'required|string|in:admin,user',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'The given data was invalid.', 'errors' => $e->errors()], 422);
        }

        $userToUpdate = User::findOrFail($id); // Find the user or fail

        // Update user with request data
        $userToUpdate->update($validatedData);

        // Fetch users with user_type 'admin'
        $admins = User::where('user_type', 'admin')->get(['name', 'email', 'user_type', 'id']);
        $users = User::where('user_type', 'user')->get(['name', 'email', 'user_type', 'id']);

        $sessionId = session()->getId();

        // Get the currently authenticated user
        $loginUser = Auth::user();
        // Get the user's tokens
        $tokens = $loginUser->tokens;

        $response = [
            'admin_info' => $userToUpdate,
            'token' => $tokens->last()->token ?? 'No token available', // Get the most recent token
            'admins' => $admins,
            'users' => $users,
            'loginUser' => $loginUser,
            'session_id' => $sessionId,
        ];

        return response()->json($response);

    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        $$sessionId = session()->getId();
        return redirect()->route('landingPage')->with('data', $sessionId);
    
    }
    public function getAdminById($id): JsonResponse
     {   
    // Fetch the user with the given ID who is also an admin
        $user = User::where('id', $id)
                    ->where('user_type', 'admin')
                    ->first(['name', 'email', 'user_type']);

        // Check if the user was found
        if ($user) {
            // Return the JSON response with the user info
            return response()->json([
                'message' => 'Successful',
                'admin_info' => $user,
            ]);
        } else {
            // Return a 404 response if the user is not found or not an admin
            return response()->json([
                'error' => 'User not found or not an admin',
            ], 404);
        }
    }
    public function getUserById($id): JsonResponse
    {   
   // Fetch the user with the given ID who is also an admin
       $user = User::where('id', $id)
                   ->where('user_type', 'user')
                   ->first(['name', 'email', 'user_type']);

       // Check if the user was found
       if ($user) {
           // Return the JSON response with the user info
           return response()->json([
               'message' => 'Successful',
               'info' => $user,
           ]);
       } else {
           // Return a 404 response if the user is not found or not an admin
           return response()->json([
               'error' => 'User not found or not an user',
           ], 404);
       }
   }
  

   // Show the user profile or update form based on the request
   public function showProfile(Request $request)
   {
       $loginUser = Auth::user(); // Get the currently authenticated user
       $sessionId = session()->getId();
       $admins = User::where('user_type', 'admin')->get(['name', 'email', 'user_type', 'id']);
       $users = User::where('user_type', 'user')->get(['name', 'email', 'user_type', 'id']);

    //    $isUpdating = $request->has('update'); // Check if 'update' parameter is present
       $isViewing = $request->has('view');    // Check if 'view' parameter is present

    //    if ($isUpdating) {
    //        // Return the view for updating profile
    //        return view('profile.update', $data);
    //    } 
       if ($isViewing) {
           // Return the view for viewing profile
           return view('auth.profile', compact('admins','users', 'loginUser', 'sessionId'));
       } else {
           // Optionally handle cases where neither condition is met
           return view('auth.landingPage', compact('admins','users', 'loginUser', 'sessionId'));
       }
   }

    // Method to get and display tokens
    public function showTokens()
    {
        // // Get the currently authenticated user
        // $user = Auth::user();

        // // Get the user's tokens
        // $tokens = $user->tokens;

        // // Return tokens as JSON for API or view for web
        // // return view('tokens', compact('tokens'));
        // return response()->json($tokens);


        // Get the currently authenticated user
        $user = Auth::user();

        // Get the tokens for the authenticated user
        $tokens = $user->tokens;

        // Optionally, get the latest token (if multiple tokens are supported)
        $latestToken = $tokens->last(); // Get the last token or adjust as needed

        // Return token details as JSON for API or view for web
        return response()->json([
            'token' => $latestToken ? $latestToken->token : 'No token found',
            'created_at' => $latestToken ? $latestToken->created_at : null,
            'last_used_at' => $latestToken ? $latestToken->last_used_at : null
        ]);
    }
    

}
