<?php

namespace App\Http\Controllers;

use App\User; 
use App\login_details; 
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

// Create class for user register and login, & logout
class AuthController extends Controller
{
    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }
    // Create user.. 
    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required',
            'nicename' => 'nullable',
            'user_url' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Validation passed, proceed with creating the admin...
        $admin = new User();
        $admin->name     = $request->input('name');
        $admin->email    = $request->input('email');
        $admin->password = Hash::make($request->input('password'));
        $admin->nicename = $request->input('name');
        $admin->role     = 'admin'; 
        $admin->user_registered = date('Y-m-d H:i:s');
        $admin->save();

        return response()->json(['message' => 'User registered successfully'], 201);
    }
    // User login here.. 
    public function userLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required',
        ]);

        // Check if user exists in the table
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();
        if (!$user) {
            return response()->json(['error' => 'User does not exist'], 404);
        }

        try {
            // Attempt to generate JWT token
            if (!$token = $this->jwt->attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['error' => 'Token expired'], 500);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => 'Token invalid'], 500);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'Token absent'], 500);
        }

        // Return token if authentication successful
        $response = response()->json(['token' => $token , 'response' => 'User '.Auth::user()->name .' login successfully']);
        $existLoginId  = login_details::where('user_id', $user->id)->exists();
        if(!$existLoginId){
            $userData             = new login_details();
            $userData->user_id    = $user->id;
            $userData->login_time = date('Y-m-d H:i:s');
            $userData->save();
            session_start();
            return $response;
        }else{
            return response()->json(['Response'=> 'User is already logged in !']);
        }
        
    }
    public function userLogout(Request $request)
    {
        // Assuming you have authenticated user available
        $user = '10';
        // Update logout time for login details associated with the user
        $affectedRows = login_details::leftJoin('users', 'login_details.user_id', '=', 'users.id')
        ->where('users.id', '10')
        ->update(['login_details.logout_time' => date('Y-m-d H:i:s')]);
        
        if ($affectedRows > 0) {
            session_destroy();
            return response()->json(['response' => 'User LOGOUT']);
        } else {
            return response()->json(['response' => 'No logout records updated']);
        }
    }
    
    
    
}
