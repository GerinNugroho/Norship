<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Store;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\V1\Controller;
use App\Http\Requests\createProductRequest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Arr;

class productController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $store = $user->store()->with('products')->first();
        $products = $store->products()->with('skus')->get();
        return response()->json(
            $products
        );
    }
    public function store(createProductRequest $request)
    {
        $validated = $request->validated();

        $store = Store::with('user')->where('user_id', Auth::user()->id)->first();

        $validated['store_id'] = $store->id;
        $validated['slug'] = Str::slug($validated['name']);

        $product = Product::create(Arr::only($validated, ['store_id', 'category_id', 'name', 'slug', 'description']));

        $validated['product_id'] = $product->id;
        $product->skus()->create(Arr::only($validated, ['product_id', 'sku', 'price', 'quantity', 'image_url']));

        return response()->json([
            'status' => true,
            'message' => 'Product berhasil ditambahkan!'
        ]);
    }
}
