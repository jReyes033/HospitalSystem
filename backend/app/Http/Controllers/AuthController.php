<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request) {
        // Validate request data
        $validatedData = $request->validate([
            'email' => 'required|string|email|max:191',
            'password' => 'required|string|min:8|max:191',
        ]);
    
        // Attempt to authenticate the user
        if (Auth::attempt($validatedData)) {
            // Authentication was successful
            $user = Auth::user();
            $token = $user->createToken('sanctum-token')->plainTextToken;
    
            return response()->json([
                'status' => 200,
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token
            ], 200);
        } else {
            // Authentication failed
            return response()->json([
                'status' => 401,
                'message' => 'Invalid credentials',
            ], 401);
        }
    }

    public function register(Request $request) {
        $validate = Validator::make($request->all(), 
        [
            'name' => 'required | string | max:191',
            'email' => 'required|string|email|max:191|unique:users,email',
            'password' => 'required | string | min:8 | max:191',
            'userType' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validate->messages()
            ], 400);
        } 

        try {
            $user = User::create([
                'name'=> $request->name,
                'email'=> $request->email,
                'password'=> $request->password,
                'userType'=> $request->userType
            ]);

            $token = $user->createToken('sanctum-token')->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token
            ];

            return response()->json([
                'status' => 200,
                'message' => "Account Created Succesfully",
                'response' => $response
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => "Something went wrong: " . $e->getMessage()
            ], 500);
        }
    }
}
