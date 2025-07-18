<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuItemsLocalizationSeeder extends Seeder
{
    public function run()
    {
        // Sample localized data for menu items
        $localizedData = [
            1 => [
                'name_en' => 'Red Lentil Soup',
                'name_de' => 'Rote Linsensuppe',
                'description_en' => 'Red lentil soup (Pakistani style)',
                'description_de' => 'Rote Linsensuppe (pakistanischer Stil)',
            ],
            2 => [
                'name_en' => 'Dal Soup',
                'name_de' => 'Dal Suppe',
                'description_en' => 'Traditional lentil soup',
                'description_de' => 'Traditionelle Linsensuppe',
            ],
            3 => [
                'name_en' => 'Mixed Vegetable Soup',
                'name_de' => 'Gemischte Gemüsesuppe',
                'description_en' => 'Soup with mixed vegetables',
                'description_de' => 'Suppe mit gemischtem Gemüse',
            ],
            // Yahan aap aur bhi IDs ke liye data add kar sakte hain
        ];

        foreach ($localizedData as $id => $data) {
            DB::table('menu_items')
                ->where('id', $id)
                ->update($data);
        }
    }
}
