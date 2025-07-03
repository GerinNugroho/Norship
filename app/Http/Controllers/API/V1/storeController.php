<?php

namespace App\Http\Controllers\API\V1;


use App\Models\Store;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\createStoreRequest;
use App\Http\Controllers\API\V1\Controller;

class storeController extends Controller
{
    public function store(createStoreRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::user()->id;
        $validated['slug'] = Str::slug($validated['name'], '-');

        Store::create($validated);
        return response()->json([
            'status' => true,
            'message' => 'Toko berhasil di buat!'
        ]);
    }

    public function show(string $id)
    {
        $store = Store::with('user')->find($id);
        return response()->json([
            'status' => true,
            'data' => $store
        ]);
    }

    public function update(Request $request, string $id)
    {
        $store = Store::find($id);
        $store->update($request->all());
        return response()->json([
            'status' => true,
            'updated' => $store,
        ]);
    }
}
