<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MenuItem; 
class Category extends Model
{
    use HasFactory;

    // Ye fields database mein fill hone deni chahiye
    protected $fillable = ['name_en', 'name_de'];

    // Category ke under menu items ka relation
    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }
}
