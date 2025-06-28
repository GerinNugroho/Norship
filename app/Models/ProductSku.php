<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSku extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'sku',
        'size_attribute_id',
        'color_attribute_id',
        'price',
        'quantity',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color()
    {
        return $this->belongsTo(ProductAttribute::class, 'color_attribute_id');
    }

    public function size()
    {
        return $this->belongsTo(ProductAttribute::class, 'size_attribute_id');
    }
}
