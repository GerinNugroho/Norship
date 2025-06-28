<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'summary',
        'cover',
    ];

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'category_id');
    }

    public function productSku()
    {
        return $this->hasMany(ProductSku::class);
    }

    public function cartItem()
    {
        return $this->hasMany(CartItem::class);
    }
}
