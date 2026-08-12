<?php

namespace Database\Seeders;

use App\Models\Carousel;
use App\Models\CarouselItem;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CarouselSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Obtener/Cargar Categorías Base
        |--------------------------------------------------------------------------
        */
        $allCategory = Category::where('slug', 'todos-los-productos')->first();
        $ritualesCategory = Category::where('slug', 'rituales')->first();
        $aromaterapiaCategory = Category::where('slug', 'aromaterapia')->first();
        $energiaCategory = Category::where('slug', 'energia-y-proteccion')->first();
        $kitsCategory = Category::where('slug', 'kits-combos')->first();

        /*
        |--------------------------------------------------------------------------
        | 2. Carruseles
        |--------------------------------------------------------------------------
        */
        $carouselSprays = Carousel::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'Sprays Áuricos',
                'subtitle' => 'Línea Samadhi',
                'description' => 'Brumas energéticas intencionadas para armonizar tu campo áurico.',
                'section' => 'home', // <--- Actualizado
                'position' => 1,
                'active' => true,
            ]
        );

        $carouselKits = Carousel::updateOrCreate(
            ['id' => 2],
            [
                'title' => 'Kits & Rituales Destacados',
                'subtitle' => 'Experiencias de Bienestar',
                'description' => 'Sets pensados para regalar o iniciar tus prácticas holísticas.',
                'section' => 'products', // <--- Actualizado
                'position' => 2,
                'active' => true,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 3. Productos y sus Categorías
        |--------------------------------------------------------------------------
        */
        $products = [
            // Sprays Áuricos (Aromaterapia)
            [
                'slug' => 'spray-calma',
                'title' => 'Calma',
                'description' => 'Bruma energética para armonizar y relajar.',
                'long_description' => 'Una combinación suave de lavanda y jazmín acompañada por la energía de la amatista. Ideal para momentos de descanso, meditación, relajación y para crear ambientes de serenidad y equilibrio emocional.',
                'ingredients' => 'Lavanda,Jazmín,Amatista',
                'price' => 15000,
                'image_url' => 'products/calma.png',
                'position' => 1,
                'carousel_id' => $carouselSprays->id,
                'category_ids' => array_filter([$aromaterapiaCategory?->id]),
            ],
            [
                'slug' => 'spray-amor',
                'title' => 'Amor',
                'description' => 'Bruma energética para abrir el corazón.',
                'long_description' => 'Elaborada con rosas, vainilla y la energía del cuarzo rosa. Favorece la apertura emocional, el amor propio, la armonía en los vínculos y la conexión con la ternura.',
                'ingredients' => 'Rosas,Vainilla,Cuarzo Rosa',
                'price' => 15000,
                'image_url' => 'products/amor.png',
                'position' => 2,
                'carousel_id' => $carouselSprays->id,
                'category_ids' => array_filter([$aromaterapiaCategory?->id]),
            ],
            [
                'slug' => 'spray-energia',
                'title' => 'Energía',
                'description' => 'Bruma energética revitalizante.',
                'long_description' => 'Una mezcla refrescante de romero y menta junto a la cornalina para estimular la vitalidad, la motivación y renovar la energía antes de comenzar el día o una actividad importante.',
                'ingredients' => 'Romero,Menta,Cornalina',
                'price' => 15000,
                'image_url' => 'products/energia.png',
                'position' => 3,
                'carousel_id' => $carouselSprays->id,
                'category_ids' => array_filter([$aromaterapiaCategory?->id, $energiaCategory?->id]),
            ],
            [
                'slug' => 'spray-proteccion',
                'title' => 'Protección',
                'description' => 'Bruma energética de protección.',
                'long_description' => 'Con romero, sándalo y turmalina negra. Diseñada para acompañar limpiezas energéticas, fortalecer el campo áurico y generar una sensación de resguardo y estabilidad.',
                'ingredients' => 'Romero,Sándalo,Turmalina Negra',
                'price' => 15000,
                'image_url' => 'products/proteccion.png',
                'position' => 4,
                'carousel_id' => $carouselSprays->id,
                'category_ids' => array_filter([$energiaCategory?->id, $aromaterapiaCategory?->id]),
            ],
            [
                'slug' => 'spray-abundancia',
                'title' => 'Abundancia',
                'description' => 'Bruma energética para potenciar la abundancia.',
                'long_description' => 'Su combinación de naranja, canela y citrino acompaña procesos de expansión, prosperidad y apertura hacia nuevas oportunidades, favoreciendo una actitud de confianza y gratitud.',
                'ingredients' => 'Naranja,Canela,Citrino',
                'price' => 15000,
                'image_url' => 'products/abundancia.png',
                'position' => 5,
                'carousel_id' => $carouselSprays->id,
                'category_ids' => array_filter([$aromaterapiaCategory?->id, $ritualesCategory?->id]),
            ],

            // Rituales, Energía y Kits
            [
                'slug' => 'kit-sahumo-sagrado',
                'title' => 'Kit Sahumo Sagrado',
                'description' => 'Set completo para limpiezas y sahumados energéticos.',
                'long_description' => 'Incluye sahumador cerámico artesanal, atado de salvia blanca, resina de copal y carbones vegetales. Perfecto para purificar espacios, cristales e intencionar el hogar.',
                'ingredients' => 'Salvia Blanca,Copal,Atados de Hierbas',
                'price' => 28000,
                'image_url' => 'products/kit-sahumo.png',
                'position' => 1,
                'carousel_id' => $carouselKits->id,
                'category_ids' => array_filter([$ritualesCategory?->id, $kitsCategory?->id, $energiaCategory?->id]),
            ],
            [
                'slug' => 'set-cristales-7-chakras',
                'title' => 'Set Cristales 7 Chakras',
                'description' => 'Piedras naturales seleccionadas para la alineación energética.',
                'long_description' => 'Siete cristales auténticos (Cuarzo Hialino, Amatista, Sodalita, Cuarzo Verde, Ojo de Tigre, Cornalina y Jaspe Rojo) en bolsita de lienzo para meditación y equilibrio de los centros energéticos.',
                'ingredients' => 'Amatista,Cuarzo,Ojo de Tigre,Cornalina,Sodalita,Jaspe',
                'price' => 22000,
                'image_url' => 'products/cristales-chakras.png',
                'position' => 2,
                'carousel_id' => $carouselKits->id,
                'category_ids' => array_filter([$energiaCategory?->id, $kitsCategory?->id]),
            ],
            [
                'slug' => 'velas-intencionadas-miel',
                'title' => 'Velas de Cera de Abeja',
                'description' => 'Velas artesanalmente enrolladas para endulzamientos y peticiones.',
                'long_description' => 'Set de 4 velas 100% cera pura de abeja con aroma natural a miel. Utilizadas para elevar vibraciones, conectar con la calidez y potenciar intenciones de luz.',
                'ingredients' => 'Cera de Abeja Pure,Pabilo de Algodón',
                'price' => 12000,
                'image_url' => 'products/velas-miel.png',
                'position' => 3,
                'carousel_id' => $carouselKits->id,
                'category_ids' => array_filter([$ritualesCategory?->id]),
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | 4. Persistencia e Integración de Relaciones
        |--------------------------------------------------------------------------
        */
        foreach ($products as $productData) {

            $product = Product::updateOrCreate(
                [
                    'slug' => $productData['slug'],
                ],
                [
                    'title' => $productData['title'],
                    'description' => $productData['description'],
                    'long_description' => $productData['long_description'],
                    'ingredients' => $productData['ingredients'],
                    'price' => $productData['price'],
                    'image_url' => $productData['image_url'],
                    'active' => true,
                ]
            );

            // Asignación de Carrusel
            if (isset($productData['carousel_id'])) {
                CarouselItem::updateOrCreate(
                    [
                        'carousel_id' => $productData['carousel_id'],
                        'product_id' => $product->id,
                    ],
                    [
                        'position' => $productData['position'],
                    ]
                );
            }

            // Asignación N a N de Categorías + Siempre incluir "Todos los productos"
            $targetCategories = $productData['category_ids'];

            if ($allCategory) {
                $targetCategories[] = $allCategory->id;
            }

            $product->categories()->sync(array_unique($targetCategories));
        }
    }
}
