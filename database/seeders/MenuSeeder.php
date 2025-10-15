<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Support\Facades\File;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // JSON file ka path
        $jsonPath = database_path('data/menu.json');

        // File ka content read karo
        $jsonContent = File::get($jsonPath);

        // JSON decode karo into PHP array
        $menuData = json_decode($jsonContent, true);

        // Loop through categories
        foreach ($menuData as $cat) {
            // Category ko firstOrCreate karo taake duplicate na ho
            $category = Category::firstOrCreate([
                'name' => $cat['Category'],
            ]);

            // Loop through items under category
            foreach ($cat['Items'] as $item) {
                MenuItem::create([
                    'category_id' => $category->id,
                    'name' => $item['Name'],
                    'description' => $item['Description'] ?? '',
                    // Price numeric hai ya nahi check karo, warna null do
                    'price' => is_numeric($item['Price (€)']) ? $item['Price (€)'] : null,
                ]);
            }
        }
    }
}
