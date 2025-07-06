<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Product;
use App\Models\ProductSku;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\addProductRequest;
use App\Http\Controllers\API\V1\Controller;
use App\Http\Requests\addSKuRequest;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class productController extends Controller
{
    public function addProduct(addProductRequest $request)
    {
        $validated = $request->validated();
        $store = Auth::user()->store;
        $validated['store_id'] = $store->id;
        $validated['slug'] = Str::slug($validated['name']);
        $product = Product::create(Arr::only($validated, ['store_id', 'category_id', 'name', 'slug', 'description']));
        $validated['product_id'] = $product->id;
        $sku = ProductSku::create(Arr::only($validated, ['product_id', 'price', 'quantity', 'image_url']));
        return response()->json([
            'status' => true,
            'message' => 'Products ditambahkan!',
            'product' => $product,
            'sku' => $sku
        ], 201);
    }

    public function addSkuProduct(addSKuRequest $request)
    {
        $validated = $request->validated();
        $sku = ProductSku::create($validated);
        return response()->json([
            'status' => true,
            'message' => 'Sku product berhasil ditambahkan',
            'data' => $sku
        ]);
    }

    public function showProducts()
    {
        $products = Product::with('skus')->get();

        return response()->json([
            'status' => true,
            'data' => $products
        ], 200);
    }

    public function showProductInCategory(string $id)
    {
        try {
            $category = Category::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Category tidak ditemukan',
            ], 404);
        }

        $products = Product::where('category_id', $category->id)->get();
        return response()->json([
            'status' => true,
            'data' => $products
        ]);
    }
}
