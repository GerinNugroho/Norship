<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class profileController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::user()->id)->with('addresses')->first();
        return response()->json([
            'status' => true,
            'data' => $user
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $user->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Prfile di update!'
        ]);
    }
}
