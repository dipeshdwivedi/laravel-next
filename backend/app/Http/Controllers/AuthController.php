<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller {

    public function login(LoginRequest $request) {
        Auth::attempt($request->only('email', 'password'));
        if (Auth::check()) {
            $token = Auth::user()->createToken('api-token')->plainTextToken;
            $user = Auth::user();

            return response()->json([
                'data' => [
                    'name' => $user->name,
                    'token' => $token,
                    'role' => $user->role
                ]
            ]);
        }
        throw ValidationException::withMessages(['email' => 'Invalid email or password.']);
    }

    /**
     * Registers a new user with the given credentials and returns a JSON response
     * with the new user's name, token, and role.
     *
     * @param  RegisterRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request) {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'role' => 'user',
            ]);

            $token = $user->createToken('api-token')->plainTextToken;

            DB::commit();

            return response()->json([
                'data' => [
                    'name' => $user->name,
                    'token' => $token,
                    'role' => $user->role
                ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            throw ValidationException::withMessages(['error' => 'Registration failed.']);
        }
    }

    public function logout() {
        // Revoke the token
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'User signed out successfully.'
        ]);
    }
}
