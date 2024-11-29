<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            $token = auth()->attempt($request->validated());
            if (!$token) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Invalid credentials!',
                ], 401);
            }
            return $this->responseWithToken($token);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred. Please try again later.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // try catch for better security
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create($request->validated());

            if (!$user) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'An excepted error occured!',
                ], 500);
            }

            $token = auth()->login($user);
            return $this->responseWithToken($token);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred. Please try again later.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function profile()
    {
        try {
            $user = auth()->user();

            return response()->json([
                'status' => 'success',
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred. Please try again later.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function logout()
    {
        try {
            auth()->logout();

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully logged out'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred. Please try again later.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function refresh()
    {
        try {
            return $this->responseWithToken(auth()->refresh());
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred. Please try again later.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    protected function responseWithToken($token)
    {
        return response()->json([
            'status' => 'success',
            'access_token' => $token,
            'type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }
}
