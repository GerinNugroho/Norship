<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSku extends Model
{
    use HasFactory;

    protected $table = 'products_skus'; // Explicitly define table name

    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'quantity',
        'image_url',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected static function booted()
    {
        static::creating(function ($product) {
            if (empty($product->sku)) {
                $product->sku = strtoupper(fake()->bothify('??-####'));
            };
        });
    }
}
