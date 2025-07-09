<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductSku;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AddSKuRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddProductRequest;
use App\Http\Controllers\API\V1\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{
    public function addProduct(AddProductRequest $request)
    {
        $user = Auth::user();
        $store = $user->store;
        if (!$store) {
            return response()->json([
                'status' => false,
                'message' => 'Anda harus memiliki toko untuk menambahkan produk',
            ], 422);
        }
        $validated = $request->validated();
        $validated['store_id'] = $store->id;
        $validated['slug'] = Str::slug($validated['name']);

        DB::beginTransaction();
        try {
            $product = Product::create($validated);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Produk berhasil ditambahkan',
                'data' => $product
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambahkan produk',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function addSkuProduct(AddSKuRequest $request)
    {
        $validated = $request->validated();
        $sku = ProductSku::create($validated);
        return response()->json([
            'status' => true,
            'message' => 'Sku product berhasil ditambahkan',
            'data' => $sku
        ]);
    }

    public function showProduct(string $id)
    {
        try {
            $product = Product::with('skus')->findOrFail($id);
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mendapatkan produk',
                'data' => $product
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Produk tidak ditemukan',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function showProducts()
    {
        $products = Product::with('skus')->get();
        return response()->json([
            'status' => true,
            'message' => 'Berhasil mendapatkan semua produk',
            'data' => $products
        ]);
    }

    public function showProductInCategory(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            $products = $category->products()->get();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mendapatkan produk dalam kategori',
                'data' => $products
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Category tidak ditemukan',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
