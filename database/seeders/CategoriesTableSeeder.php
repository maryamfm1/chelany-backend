<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        // English JSON file path
        $menuEnPath = storage_path('app/menus/menu_en.json');
        // German JSON file path
        $menuDePath = storage_path('app/menus/menu_de.json');

        // JSON files read karo aur decode karo
        $menuEn = json_decode(file_get_contents($menuEnPath), true);
        $menuDe = json_decode(file_get_contents($menuDePath), true);

        // Dono arrays mein categories iterate karo
        foreach ($menuEn as $index => $categoryEn) {
            $categoryDe = $menuDe[$index] ?? null;

            DB::table('categories')->updateOrInsert(
                ['name_en' => $categoryEn['Category']],
                [
                    'name_en' => $categoryEn['Category'],
                    'name_de' => $categoryDe['Category'] ?? $categoryEn['Category']
                ]
            );
        }
    }
}
