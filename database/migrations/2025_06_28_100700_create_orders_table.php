<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->uuid('checkout_session_id');
            $table->string('invoice_number')->unique();
            $table->enum('status', ['waiting_for_payment', 'processing', 'shipped', 'delivered', 'completed', 'cancelled']);
            $table->text('shipping_address');
            $table->string('shipping_provider')->nullable();
            $table->string('shipping_tracking_number')->nullable();
            $table->decimal('sub_total', 12, 2);
            $table->decimal('shipping_cost', 12, 2)->default(0);
            $table->decimal('grand_total', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
