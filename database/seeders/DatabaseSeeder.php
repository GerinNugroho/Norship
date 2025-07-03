<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductSku;
use App\Models\Store;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create a specific user for easy access
        User::factory()->admin()->create([
            'first_name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'admin1234'
        ]);

        User::factory()->superAdmin()->create([
            'first_name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => 'admin1234'
        ]);

        User::factory()->create([
            'first_name' => 'User',
            'email' => 'user@example.com',
            'password' => 'admin1234'
        ]);

        // 2. Create a set of regular users
        $users = User::factory(count: 20)->create();

        // 3. Create global categories for products
        $parentCategories = Category::factory(5)->create();
        $parentCategories->each(function ($parent) {
            Category::factory(rand(2, 4))->create(['parent_id' => $parent->id]);
        });
        $allCategories = Category::all();

        // 4. Select some users to become sellers and create stores for them
        $stores = collect();
        $users->take(8)->each(function ($user) use ($stores) {
            $stores->push(Store::factory()->for($user)->create());
        });

        // 5. Create products and their SKUs for each store
        $allSkus = collect();
        $stores->each(function ($store) use ($allSkus, $allCategories) {
            // Create 8-15 products for each store
            Product::factory(rand(8, 15))
                ->for($store)
                ->for($allCategories->random())
                ->create()
                ->each(function ($product) use ($allSkus) {
                    // Create 1-4 SKUs for each product
                    $skus = ProductSku::factory(rand(1, 4))->for($product)->create();
                    $allSkus->push(...$skus);
                });
        });

        // 6. Simulate the full order lifecycle for users who are not sellers
        $buyers = User::whereDoesntHave('store')->get();

        $buyers->each(function ($buyer) use ($allSkus) {
            // Each buyer makes 1-3 separate "checkout" sessions
            for ($i = 0; $i < rand(1, 3); $i++) {
                // In each checkout, they buy 2-5 different items from random stores
                $itemsToBuy = $allSkus->random(rand(2, 5));

                // Group the selected items by their store ID
                $itemsByStore = $itemsToBuy->groupBy(fn($sku) => $sku->product->store_id);

                $checkoutSessionId = Str::uuid();
                $totalPaymentAmount = 0;

                // For each store in the checkout, create a separate order
                $itemsByStore->each(function ($skus, $storeId) use ($buyer, $checkoutSessionId, &$totalPaymentAmount) {
                    $subTotal = $skus->sum(fn($sku) => $sku->price); // Assuming quantity is 1
                    $shippingCost = rand(10000, 30000);
                    $grandTotal = $subTotal + $shippingCost;
                    $totalPaymentAmount += $grandTotal;

                    // Create the order record
                    $order = Order::factory()->create([
                        'user_id' => $buyer->id,
                        'store_id' => $storeId,
                        'checkout_session_id' => $checkoutSessionId,
                        'status' => 'processing', // Assume payment is successful for this seed
                        'sub_total' => $subTotal,
                        'shipping_cost' => $shippingCost,
                        'grand_total' => $grandTotal,
                    ]);

                    // Create the corresponding order items
                    $skus->each(function ($sku) use ($order) {
                        OrderItem::factory()->create([
                            'order_id' => $order->id,
                            'products_sku_id' => $sku->id,
                            'quantity' => 1, // Keeping it simple for the seeder
                            'price_at_purchase' => $sku->price,
                            'product_name_snapshot' => $sku->product->name,
                        ]);
                    });
                });

                // Create a single payment record for the entire checkout session
                if ($totalPaymentAmount > 0) {
                    Payment::factory()->create([
                        'checkout_session_id' => $checkoutSessionId,
                        'user_id' => $buyer->id,
                        'amount' => $totalPaymentAmount,
                        'status' => 'successful',
                        'transaction_id' => 'TR-' . strtoupper(Str::random(12)),
                    ]);
                }
            }
        });
    }
}
