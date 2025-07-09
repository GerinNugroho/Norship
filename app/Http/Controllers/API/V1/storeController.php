<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateStoreRequest;
use App\Http\Controllers\API\V1\Controller;
use App\Http\Requests\EditStoreRequest;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    public function createStore(CreateStoreRequest $request)
    {
        $user = User::find(Auth::id());
        if ($user->store) {
            return response()->json([
                'status' => false,
                'message' => 'Toko sudah ada!',
                'data' => $user->store
            ], 422);
        }

        $validated = $request->validated();
        $validated['user_id'] = $user->id;
        $validated['slug'] = Str::slug($validated['name']);

        DB::beginTransaction();
        try {
            if ($user->role !== 'admin') {
                $user->update(['role' => 'admin']);
            }
            $store = Store::create($validated);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Store dibuat!',
                'data' => $store
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal membuat store',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function editStore(EditStoreRequest $request, string $id)
    {
        $validated = $request->validated();
        try {
            $store = Store::findOrFail($id);
            if ($store->user_id !== Auth::id()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Anda tidak memiliki akses untuk mengedit toko ini!',
                ], 403);
            }
            $store->update($validated);
            return response()->json([
                'status' => true,
                'message' => 'Toko diedit!',
                'data' => $store
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Toko tidak ada!',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
