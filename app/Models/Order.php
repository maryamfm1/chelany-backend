<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_id',            // add this for order_id field fillable
        'name',
        'email',
        'phone',
        'address',
        'items',
        'total_price',
        'payment_method',
        'payment_details',
        'status',
    ];

    protected $casts = [
        'items' => 'array',
    ];
}
