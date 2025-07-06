<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\addAddressRequest;
use App\Http\Controllers\API\V1\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class addressController extends Controller
{
    public function store(addAddressRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::user()->id;
        $address  = Address::create($validated);
        return response()->json([
            'status' => true,
            'message' => 'Address ditambahkan!',
            'data' => $address
        ], 201);
    }

    public function update(Request $request, string $id)
    {
        try {
            $address = Address::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Address tidak ada!'
            ], 404);
        }
        $address->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Address diupdate!'
        ], 200);
    }
}
