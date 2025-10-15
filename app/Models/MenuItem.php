<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name_en',
        'name_de',
        'description_en',
        'description_de',
        'price'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
