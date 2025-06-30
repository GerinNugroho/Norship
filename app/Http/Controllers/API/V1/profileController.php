<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class profileController extends Controller
{
    public function profile(Request $request)
    {
        return response()->json([
            'avatar' => Auth::user()->avatar,
            'first_name' => Auth::user()->first_name,
            'last_name' => Auth::user()->last_name,
            'username' => Auth::user()->username,
            'email' => Auth::user()->email,
            'phone_number' => Auth::user()->phone_number,
        ], 200);
    }
}
