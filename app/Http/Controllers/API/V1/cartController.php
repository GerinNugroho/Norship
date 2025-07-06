<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\API\V1\Controller;
use App\Http\Requests\addCartRequest;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class cartController extends Controller
{
    public function addCart(addCartRequest $request)
    {
        $validated = $request->validated();
        $cart = null;
        if (!Auth::user()->cart) {
            $cart = Cart::create([
                'user_id' => Auth::user()->id
            ]);
        } else {
            $cart = Cart::find(Auth::user()->cart->id);
        }
        $validated['cart_id'] = $cart->id;

        $cartItem = CartItem::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'masuk ke cart',
            'data' => $cartItem->with('productSku')->get()
        ], 201);
    }

    public function showCart()
    {
        $carts = Cart::with('cartItems')->find(Auth::user()->cart->id);

        return response()->json([
            'status' => true,
            'data' => $carts
        ]);
    }

    public function clearCart(string $id)
    {
        if (!Auth::user()->cart) {
            return response()->json([
                'status' => false,
                'message' => 'kesalahan berpikir!'
            ], 404);
        }
        try {
            $cart = Cart::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'lain kali id nya diperhatikan ya!!'
            ], 404);
        }

        $cart->delete();
        return response()->json([
            'status' => true,
            'message' => 'cart dihapus!',
        ]);
    }
}
