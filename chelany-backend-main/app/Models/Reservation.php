<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    // 🎯 Mass assignable fields
    protected $fillable = [
        'name',
        'email',
        'phone',
        'date',
        'time',
        'guests',
        'message',
    ];

    // 🕒 Casts for proper formatting and access
    protected $casts = [
        // Laravel automatically converts 'date' column to Carbon instance in 'Y-m-d' format
        'date' => 'date:Y-m-d',

        // 'time' ko datetime cast krna zaroori nahi agar DB mein time type hai, 
        // lekin agar chaho to readable format ke liye aise cast kar sakte ho:
        'time' => 'datetime:H:i:s',

        // created_at/updated_at bhi Carbon instance ban jayein
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
