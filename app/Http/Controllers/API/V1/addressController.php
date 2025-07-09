<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddAddressRequest;
use App\Http\Controllers\API\V1\Controller;
use App\Http\Requests\UpdateAddressRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AddressController extends Controller
{
    public function store(AddAddressRequest $request)
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

    public function update(UpdateAddressRequest $request, string $id)
    {
        try {
            $address = Address::findOrFail($id);
            if ($address->user_id !== Auth::id()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Anda tidak memiliki akses untuk mengupdate address ini!',
                ], 403);
            }
            $address->update($request->validated());
            return response()->json([
                'status' => true,
                'message' => 'Address diupdate!',
                'updated' => $address
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Address tidak ada!',
                'errors' => $e->getMessage()
            ], 404);
        }
    }
}
