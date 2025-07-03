<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\loginRequestUser;
use App\Http\Requests\signUpRequestUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class authController extends Controller
{
    public function login(loginRequestUser $request)
    {
        $validated = $request->validated();
        if (!Auth::attempt($validated)) {
            return response()->json([
                'status' => false,
                'message' => 'Proses login gagal!',
            ], 404);
        };

        $token = $request->user()->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Proses login berhasil!',
            'token' => $token
        ], 200);
    }

    public function signUp(signUpRequestUser $request)
    {
        $validated = $request->validated();
        User::create($validated);
        return response()->json([
            'status' => true,
            'message' => 'Proses registrasi berhasil!'
        ], 201);
    }

    public function logout(Request $request)
    {
        /** @var \Laravel\Sanctum\PersonalAccessToken $token */

        $token = $request->user()->currentAccessToken();
        $token->delete();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil logout!'
        ], 200);
    }
}
