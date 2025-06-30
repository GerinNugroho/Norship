<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentDetail;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductSku;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Categories and subcategories
        Category::factory()->count(5)->create()->each(function ($category) {
            SubCategory::factory()->count(2)->create(['category_id' => $category->id]);
        });

        // Attributes (shared pool of colors and sizes)
        $colors = ProductAttribute::factory()->count(5)->create(['type' => 'color']);
        $sizes = ProductAttribute::factory()->count(5)->create(['type' => 'size']);

        // Products and SKUs
        SubCategory::all()->each(function ($sub) use ($colors, $sizes) {
            Product::factory()->count(3)->create([
                'category_id' => $sub->id
            ])->each(function ($product) use ($colors, $sizes) {
                foreach (range(1, 3) as $i) {
                    ProductSku::factory()->create([
                        'product_id' => $product->id,
                        'color_attribute_id' => $colors->random()->id,
                        'size_attribute_id' => $sizes->random()->id,
                    ]);
                }
            });
        });

        // Create users with addresses and carts
        User::factory()
            ->count(10)
            ->has(Address::factory()->count(2))
            ->has(Cart::factory())
            ->create()
            ->each(function ($user) {

                // Create cart items with product and SKU references
                if ($user->cart) {
                    $skus = ProductSku::inRandomOrder()->take(3)->get();
                    foreach ($skus as $sku) {
                        CartItem::create([
                            'cart_id' => $user->cart->id,
                            'product_id' => $sku->product_id,
                            'quantity' => rand(1, 3),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            });

        // Orders and order items
        User::all()->each(function ($user) {
            Order::factory()->count(2)->create([
                'user_id' => $user->id
            ])->each(function ($order) {
                $skus = ProductSku::inRandomOrder()->take(3)->get();
                foreach ($skus as $sku) {
                    OrderItem::factory()->create([
                        'order_id' => $order->id,
                        'product_sku_id' => $sku->id,
                    ]);
                }
                // Payment
                PaymentDetail::factory()->create([
                    'order_id' => $order->id
                ]);
            });
        });


        $this->call([
            TestingSeeder::class,
        ]);
    }
}
