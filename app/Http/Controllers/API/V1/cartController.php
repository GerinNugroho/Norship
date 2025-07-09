<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\API\V1\Controller;
use App\Http\Requests\AddCartRequest;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addCart(AddCartRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::user();

        $cart = $user->cart ?? $user->cart()->create(['user_id' => $user->id]);

        $validated['cart_id'] = $cart->id;

        $cartItem = CartItem::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Masuk ke cart',
            'data' => $cartItem->with('productSku')->get()
        ], 201);
    }

    public function showCart()
    {
        $cart = Auth::user()->cart;
        if (!$cart || $cart->cartItems->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Cart belum ada',
                'data' => null
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'Berhasil mendapatkan cart',
            'data' => $cart->with('cartItems')->get()
        ]);
    }

    public function clearCart(string $id)
    {
        $user = Auth::user();
        if (!$user->cart || $user->cart->id != $id) {
            return response()->json([
                'status' => false,
                'message' => 'Cart tidak ada atau tidak punya anda'
            ], 404);
        }
        try {
            $cart = Cart::findOrFail($id);
            $cart->delete();
            return response()->json([
                'status' => true,
                'message' => 'Cart berhasil dihapus',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Cart tidak ditemukan',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
