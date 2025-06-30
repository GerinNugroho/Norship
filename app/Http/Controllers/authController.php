<?php

namespace App\Http\Controllers;

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
        }
        ;

        $user = User::where('email', $validated['email'])->first();

        $token = $user->createToken('Token Login')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Proses login berhasil!',
            'token' => $token
        ], 200);
    }

    public function signUp(signUpRequestUser $request)
    {
        $validated = $request->validated();
        User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $request['last_name'],
            'username' => $validated['username'],
            'password' => bcrypt($validated['password']),
            'email' => $validated['email'],
            'birth_of_date' => $validated['birth_of_date'],
            'phone_number' => $validated['phone_number'],
            'role' => $validated['role']
        ]);
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
            'message' => 'Logout telah berhasil!'
        ], 200);
    }
}
