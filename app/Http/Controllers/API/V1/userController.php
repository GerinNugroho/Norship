<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\storeUserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json([
            $users
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeUserRequest $request)
    {
        $validated = $request->validated();
        User::create($validated);
        return response()->json([
            'status' => false,
            'message' => 'User berhasil ditambhakan!',

        ], 2001);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $error) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
        return response()->json([
            'status' => true,
            'data' => $user
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $error) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan!',
            ], 404);
        }
        $user->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diupdate!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $error) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan!',
            ], 404);
        }
        $user->delete();
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus!'
        ]);
    }
}
