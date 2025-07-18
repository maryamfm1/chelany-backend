<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuItemsTableSeeder extends Seeder
{
    public function run()
    {
        $menuEnPath = storage_path('app/menus/menu_en.json');
        $menuDePath = storage_path('app/menus/menu_de.json');

        $enData = json_decode(file_get_contents($menuEnPath), true);
        $deData = json_decode(file_get_contents($menuDePath), true);

        foreach ($enData as $catIndex => $categoryBlock) {
            $categoryEn = $categoryBlock['Category'];
            $itemsEn = $categoryBlock['Items'];

            $categoryDe = $deData[$catIndex]['Category'] ?? $categoryEn;
            $itemsDe = $deData[$catIndex]['Items'] ?? [];

            // Category ka id le lo, pehle se insert ho chuka hai categories table mein
            $categoryId = DB::table('categories')
                ->where('name_en', $categoryEn)
                ->value('id');

            foreach ($itemsEn as $itemIndex => $itemEn) {
                $itemDe = $itemsDe[$itemIndex] ?? [];

                DB::table('menu_items')->updateOrInsert(
                    [
                        'category_id' => $categoryId,
                        'name_en' => $itemEn['Name'],
                    ],
                    [
                        'category_id' => $categoryId,
                        'name_en' => $itemEn['Name'],
                        'description_en' => $itemEn['Description'] ?? '',
                        'price' => $itemEn['Price (€)'] ?? null,
                        'name_de' => $itemDe['Name'] ?? $itemEn['Name'],
                        'description_de' => $itemDe['Description'] ?? $itemEn['Description'] ?? '',
                    ]
                );
            }
        }
    }
}
