<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Todos los productos',
                'description' => 'Explora nuestro catálogo completo de productos holísticos y de bienestar.',
                'position' => 1,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'name' => 'Sprays áuricos',
                'description' => 'Brumas energéticas para armonizar y limpiar tu campo áurico y espacios.',
                'position' => 2,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Perfumes áuricos',
                'description' => 'Fragancias intencionadas para elevar tu vibración y acompañar tu día.',
                'position' => 3,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Velas',
                'description' => 'Velas de cera natural para iluminar y ambientar tus momentos de introspección.',
                'position' => 4,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Difusores',
                'description' => 'Difusores de aroma para mantener tus ambientes en constante armonía.',
                'position' => 5,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Kits y Combos',
                'description' => 'Combinaciones seleccionadas especialmente para regalo o para iniciar tus prácticas.',
                'position' => 6,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Refill',
                'description' => 'Repuestos ecológicos para recargar tus envases favoritos.',
                'position' => 7,
                'is_active' => true,
                'is_featured' => false,
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::updateOrCreate(
                ['slug' => Str::slug($categoryData['name'])],
                [
                    'name' => $categoryData['name'],
                    'description' => $categoryData['description'],
                    'position' => $categoryData['position'],
                    'is_active' => $categoryData['is_active'],
                    'is_featured' => $categoryData['is_featured'],
                    'meta_title' => $categoryData['name'] . ' | Samadhi',
                    'meta_description' => $categoryData['description'],
                ]
            );
        }
    }
}
