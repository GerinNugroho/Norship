<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'recipient_name',
        'phone_number',
        'address_1',
        'address_2',
        'country',
        'province',
        'regency',
        'district',
        'postal_code',
        'is_default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
