<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\signInRequest;
use App\Http\Requests\signUpRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\V1\Controller;

class authController extends Controller
{
    public function signUp(signUpRequest $request)
    {
        $validated = $request->validated();
        $user = User::create($validated);
        return response()->json([
            'status' => true,
            'message' => 'Register berhasil',
            'data' => $user
        ], 201);
    }

    public function signIn(signInRequest $request)
    {
        $validated = $request->validated();
        if (!Auth::attempt($validated)) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ada!',
                'data' => null
            ], 404);
        }
        $user = User::where('email', $validated['email'])->first();

        $token = $user->createToken('Auth Token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login berhasil!',
            'token' => $token,
            'data' => $user
        ], 200);
    }

    public function signOut(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => true,
            'message' => 'User logout!',
            'data' => $request->user()
        ], 200);
    }

    public function profile()
    {
        $user = User::with('store')->find(Auth::user()->id);

        return response()->json([
            'status' => true,
            'data' => $user
        ]);
    }
}
