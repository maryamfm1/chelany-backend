<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_id',
        'name',
        'email',
        'phone',
        'address',        // ✅ Address added
        'items',
        'total_price',
        'payment_method',
        'payment_details',
        'status',
        'instructions',   // ✅ Instructions field added
        'tip',  
    ];

    protected $casts = [
        'items' => 'array',  // JSON decode automatically
    ];
}
