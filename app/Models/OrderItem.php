<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'products_sku_id',
        'quantity',
        'price_at_purchase',
        'product_name_snapshot',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function productSku(): BelongsTo
    {
        return $this->belongsTo(ProductSku::class, 'products_sku_id');
    }
}
