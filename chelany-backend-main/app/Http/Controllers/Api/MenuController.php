<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->query('lang', 'en'); // default 'en' language hai

        // categories ke sath menu items load karo, language ke hisaab se field select karo
        $categories = Category::with('menuItems')->get()->map(function ($category) use ($lang) {
            return [
                'id' => $category->id,
                'name' => $lang === 'de' ? $category->name_de : $category->name_en,
                'items' => $category->menuItems->map(function ($item) use ($lang) {
                    return [
                        'id' => $item->id,
                        'name' => $lang === 'de' ? $item->name_de : $item->name_en,
                        'description' => $lang === 'de' ? $item->description_de : $item->description_en,
                        'price' => $item->price,
                    ];
                }),
            ];
        });

        return response()->json($categories);
    }
}
