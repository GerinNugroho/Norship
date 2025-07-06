<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\createStoreRequest;
use App\Http\Controllers\API\V1\Controller;
use App\Http\Requests\editStoreRequest;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;

class storeController extends Controller
{
    public function createStore(createStoreRequest $request)
    {
        if (Auth::user()->store) {
            return response()->json([
                'status' => false,
                'message' => 'Toko sudah ada!'
            ], 422);
        }

        $user = User::find(Auth::user()->id);
        $validated = $request->validated();
        $validated['user_id'] = Auth::user()->id;
        $validated['slug'] = Str::slug($validated['name']);
        $user->update([
            'role' => 'admin'
        ]);
        $store = Store::create($validated);
        return response()->json([
            'status' => true,
            'message' => 'Store dibuat!',
            'data' => $store
        ], 201);
    }
    public function editStore(editStoreRequest $request, string $id)
    {
        $validated = $request->validated();
        try {
            $store = Store::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Toko tidak ada!',
            ], 404);
        }
        $store->update($validated);
        return response()->json([
            'status' => true,
            'message' => 'Toko diedit!',
            'data' => $store
        ]);
    }
}
