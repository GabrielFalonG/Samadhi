<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Cargar Categorías Base
        |--------------------------------------------------------------------------
        */
        $allCategory       = Category::where('slug', 'todos-los-productos')->first();
        $spraysCategory    = Category::where('slug', 'sprays-auricos')->first();
        $perfumesCategory  = Category::where('slug', 'perfumes-auricos')->first();
        $velasCategory     = Category::where('slug', 'velas')->first();
        $difusoresCategory = Category::where('slug', 'difusores')->first();
        $kitsCategory      = Category::where('slug', 'kits-y-combos')->first();
        $refillCategory    = Category::where('slug', 'refill')->first();

        /*
        |--------------------------------------------------------------------------
        | 2. Definición de los 50 Productos
        |--------------------------------------------------------------------------
        */
        $products = [
            // ==================== SPRAYS ÁURICOS (1-9) ====================
            [
                'title'            => 'Spray Áurico Calma Profunda',
                'description'      => 'Bruma relajante para momentos de meditación y descanso.',
                'long_description' => 'Formulado con aceites esenciales de lavanda, manzanilla y microdosis de cuarzo amatista. Ayuda a disipar la tensión mental y favorece el descanso reparador.',
                'ingredients'      => 'Lavanda, Manzanilla, Amatista, Agua Desmineralizada',
                'price'            => 15000,
                'image_url'        => 'products/spray-calma.png',
                'category_ids'     => array_filter([$spraysCategory?->id]),
            ],
            [
                'title'            => 'Spray Áurico Amor Propio',
                'description'      => 'Bruma energética para reconectar con la ternura y la compasión.',
                'long_description' => 'Sinergia de rosas silvestre, geranio y elixir de cuarzo rosa. Potencia el afecto personal, alivia pesares del corazón y promueve la armonía.',
                'ingredients'      => 'Rosas, Geranio, Cuarzo Rosa, Alcohol de Cereal',
                'price'            => 15000,
                'image_url'        => 'products/spray-amor.png',
                'category_ids'     => array_filter([$spraysCategory?->id]),
            ],
            [
                'title'            => 'Spray Áurico Vitalidad & Fuego',
                'description'      => 'Bruma estimulante para reactivar la energía y la fuerza vital.',
                'long_description' => 'Mezcla cítrica con notas de bergamota, jengibre y cornalina. Ideal para iniciar la mañana con dinamismo o superar momentos de apatía.',
                'ingredients'      => 'Bergamota, Jengibre, Cornalina',
                'price'            => 15000,
                'image_url'        => 'products/spray-vitalidad.png',
                'category_ids'     => array_filter([$spraysCategory?->id]),
            ],
            [
                'title'            => 'Spray Áurico Escudo de Protección',
                'description'      => 'Bruma protectora para sellar y resguardar el campo energético.',
                'long_description' => 'Combina ruda, romero, sándalo y turmalina negra. Indicada para utilizar antes de ingresar a ambientes concurridos o cargados.',
                'ingredients'      => 'Ruda, Romero, Sándalo, Turmalina Negra',
                'price'            => 15500,
                'image_url'        => 'products/spray-proteccion.png',
                'category_ids'     => array_filter([$spraysCategory?->id]),
            ],
            [
                'title'            => 'Spray Áurico Abundancia & Prosperidad',
                'description'      => 'Bruma intencionada para la apertura de caminos económicos.',
                'long_description' => 'Con esencia natural de canela, naranja dulce y polvo de citrino. Ayuda a sostener una mentalidad de gratitud y merecimiento.',
                'ingredients'      => 'Canela, Naranja Dulce, Citrino',
                'price'            => 15000,
                'image_url'        => 'products/spray-abundancia.png',
                'category_ids'     => array_filter([$spraysCategory?->id]),
            ],
            [
                'title'            => 'Spray Áurico Claridad Mental',
                'description'      => 'Bruma fresca para potenciar la concentración y el enfoque.',
                'long_description' => 'Mezcla de menta piperita, eucalipto y flor de fluorita. Limpia la bruma mental durante largas jornadas de estudio o trabajo.',
                'ingredients'      => 'Menta Piperita, Eucalipto, Fluorita',
                'price'            => 14500,
                'image_url'        => 'products/spray-claridad.png',
                'category_ids'     => array_filter([$spraysCategory?->id]),
            ],
            [
                'title'            => 'Spray Áurico Conexión Espiritual',
                'description'      => 'Bruma mística para prácticas de yoga, tarot o canalización.',
                'long_description' => 'Extractos sagrados de mirra, incienso olíbano y cuarzo transparente. Eleva la frecuencia del espacio y facilita estados profundos de interiorización.',
                'ingredients'      => 'Incienso Olíbano, Mirra, Cuarzo Transparente',
                'price'            => 16000,
                'image_url'        => 'products/spray-conexion.png',
                'category_ids'     => array_filter([$spraysCategory?->id]),
            ],
            [
                'title'            => 'Spray Áurico Limpieza de Espacios',
                'description'      => 'Bruma purificante para ambientes, vehículos y lugares de trabajo.',
                'long_description' => 'Fórmula concentrada de palo santo, salvia blanca y sal marina. Elimina energías estancadas sin necesidad de humo.',
                'ingredients'      => 'Palo Santo, Salvia Blanca, Sal Marina',
                'price'            => 15500,
                'image_url'        => 'products/spray-limpieza.png',
                'category_ids'     => array_filter([$spraysCategory?->id]),
            ],
            [
                'title'            => 'Spray Áurico Armonía Familiar',
                'description'      => 'Bruma suave para pacificar vínculos y promover el diálogo pacífico.',
                'long_description' => 'Perfume botánico de azahar, tilo y cuarzo azul. Calma tensiones en zonas comunes del hogar.',
                'ingredients'      => 'Azahar, Tilo, Cuarzo Azul',
                'price'            => 15000,
                'image_url'        => 'products/spray-armonia.png',
                'category_ids'     => array_filter([$spraysCategory?->id]),
            ],

            // ==================== PERFUMES ÁURICOS (10-18) ====================
            [
                'title'            => 'Perfume Áurico Elixir de Venus',
                'description'      => 'Perfume botánico con notas florales amaderadas en roll-on.',
                'long_description' => 'Extracto de ylang ylang, jazmín de noche y aceite vegetal de jojoba macerado con cuarzo rosa. Aplicación directa en puntos de pulso.',
                'ingredients'      => 'Ylang Ylang, Jazmín, Aceite de Jojoba, Cuarzo Rosa',
                'price'            => 18500,
                'image_url'        => 'products/perfume-venus.png',
                'category_ids'     => array_filter([$perfumesCategory?->id]),
            ],
            [
                'title'            => 'Perfume Áurico Místico Sándalo',
                'description'      => 'Perfume oleoso con cálidas notas amaderadas de oriente.',
                'long_description' => 'Aceite esencial puro de sándalo australiano macerado con resina de benjuí. Acompaña estados de serenidad personal.',
                'ingredients'      => 'Sándalo, Benjuí, Aceite de Almendras',
                'price'            => 19000,
                'image_url'        => 'products/perfume-sandalo.png',
                'category_ids'     => array_filter([$perfumesCategory?->id]),
            ],
            [
                'title'            => 'Perfume Áurico Alquimia Solar',
                'description'      => 'Perfume botánico energizante con toque especiado.',
                'long_description' => 'Combinación cálida de neroli, mandarina y clavo de olor. Diseñado para activar la autoconfianza y el magnetismo personal.',
                'ingredients'      => 'Neroli, Mandarina, Clavo de Olor',
                'price'            => 18000,
                'image_url'        => 'products/perfume-solar.png',
                'category_ids'     => array_filter([$perfumesCategory?->id]),
            ],
            [
                'title'            => 'Perfume Áurico Noche Estrellada',
                'description'      => 'Perfume intencionado para potenciar la intuición nocturna.',
                'long_description' => 'Gotas de lavandín, mejorana y piedra de la luna disueltas en base vegetal suave. Ideal para antes de dormir.',
                'ingredients'      => 'Lavandín, Mejorana, Piedra de la Luna',
                'price'            => 18500,
                'image_url'        => 'products/perfume-noche.png',
                'category_ids'     => array_filter([$perfumesCategory?->id]),
            ],
            [
                'title'            => 'Perfume Áurico Loto Sagrado',
                'description'      => 'Esencia concentrada de flor de loto y lirios de agua.',
                'long_description' => 'Aroma sutil y refinado que simboliza la pureza de la mente. Presentación en frasco de vidrio violeta fotoprotector.',
                'ingredients'      => 'Flor de Loto, Lirio, Aceite de Sésamo',
                'price'            => 20000,
                'image_url'        => 'products/perfume-loto.png',
                'category_ids'     => array_filter([$perfumesCategory?->id]),
            ],
            [
                'title'            => 'Perfume Áurico Sombra & Luz',
                'description'      => 'Perfume alquímico equilibrante de polaridades.',
                'long_description' => 'Notas contrapuestas de pachulí terroso y flor de azahar brillante. Integra aspectos emocionales en conflicto.',
                'ingredients'      => 'Pachulí, Azahar, Aceite de Coco Neutro',
                'price'            => 18000,
                'image_url'        => 'products/perfume-sombra-luz.png',
                'category_ids'     => array_filter([$perfumesCategory?->id]),
            ],
            [
                'title'            => 'Perfume Áurico Bosque Sagrado',
                'description'      => 'Aroma silvestre con esencias de pino, enebro y musgo.',
                'long_description' => 'Evoca la calma de una caminata entre árboles añejos. Aporta enraizamiento y estabilidad ante la prisa diaria.',
                'ingredients'      => 'Pino Silvestre, Enebro, Vetiver',
                'price'            => 18500,
                'image_url'        => 'products/perfume-bosque.png',
                'category_ids'     => array_filter([$perfumesCategory?->id]),
            ],
            [
                'title'            => 'Perfume Áurico Templo de Ambar',
                'description'      => 'Perfume oriental denso, resinoso y protector.',
                'long_description' => 'Elaborado con resina de ámbar vegetal, vainilla negra y mirra. Deja una estela cálida y acogedora.',
                'ingredients'      => 'Ámbar Vegetal, Vainilla Negra, Mirra',
                'price'            => 19500,
                'image_url'        => 'products/perfume-ambar.png',
                'category_ids'     => array_filter([$perfumesCategory?->id]),
            ],
            [
                'title'            => 'Perfume Áurico Brisa Marina',
                'description'      => 'Perfume fresco y acuático enriquecido con sales puras.',
                'long_description' => 'Esencias botánicas de algas, menta suave y lemongras. Renueva el estado de ánimo y refresca los sentidos.',
                'ingredients'      => 'Lemongrass, Menta Marina, Sal Himalaya',
                'price'            => 17500,
                'image_url'        => 'products/perfume-brisa.png',
                'category_ids'     => array_filter([$perfumesCategory?->id]),
            ],

            // ==================== VELAS (19-27) ====================
            [
                'title'            => 'Vela de Soja Aconchego',
                'description'      => 'Vela aromática en vaso de vidrio reutilizable con aroma a vainilla.',
                'long_description' => 'Vertida a mano con cera de soja 100% ecológica, pabilo de algodón no tratado y aroma de coco y vainilla.',
                'ingredients'      => 'Cera de Soja, Aceite de Vainilla, Coco, Pabilo Algodón',
                'price'            => 13500,
                'image_url'        => 'products/vela-aconchego.png',
                'category_ids'     => array_filter([$velasCategory?->id]),
            ],
            [
                'title'            => 'Vela Intencionada Transmutación',
                'description'      => 'Vela de cera vegetal con flores secas de lavanda y amatista.',
                'long_description' => 'Al encenderse, la amatista interior libera su energía sanadora mientras se esparcen las flores de lavanda.',
                'ingredients'      => 'Cera de Soja, Lavanda Seca, Cristal Amatista',
                'price'            => 16000,
                'image_url'        => 'products/vela-transmutacion.png',
                'category_ids'     => array_filter([$velasCategory?->id]),
            ],
            [
                'title'            => 'Vela en Molde Diosa Ostara',
                'description'      => 'Vela de figura esculpida artesanalmente sin vaso.',
                'long_description' => 'Realizada con mezcla de cera de soja dura y cera de abeja natural. Pieza decorativa y ritual.',
                'ingredients'      => 'Cera de Soja, Cera de Abeja',
                'price'            => 11000,
                'image_url'        => 'products/vela-ostara.png',
                'category_ids'     => array_filter([$velasCategory?->id]),
            ],
            [
                'title'            => 'Vela Aromática Canela & Manzana',
                'description'      => 'Vela tibia ideal para épocas frías y reuniones en el hogar.',
                'long_description' => 'Fragancia reconfortante que evoca hogar y calidez. Duración estimada de combustión: 40 horas continuas.',
                'ingredients'      => 'Cera de Soja, Esencia de Canela y Manzana',
                'price'            => 14000,
                'image_url'        => 'products/vela-canela.png',
                'category_ids'     => array_filter([$velasCategory?->id]),
            ],
            [
                'title'            => 'Vela de Noche Miel & Flor de Azahar',
                'description'      => 'Set de 6 velas pequeñas flotantes para altares o tinas.',
                'long_description' => 'Elaboradas con cera pura de abeja de apicultura sustentable. Aroma naturalmente dulce.',
                'ingredients'      => 'Cera de Abeja Pura, Pabilo Delgado',
                'price'            => 9500,
                'image_url'        => 'products/vela-miel-azahar.png',
                'category_ids'     => array_filter([$velasCategory?->id]),
            ],
            [
                'title'            => 'Vela Ritual Salvia & Romero',
                'description'      => 'Vela especial para consagrar espacios o realizar limpiezas.',
                'long_description' => 'Contiene hierbas trituradas de salvia y romero integradas en la cera. Emite un suave crujido herbal al arder.',
                'ingredients'      => 'Cera de Soja, Salvia Molida, Romero',
                'price'            => 14500,
                'image_url'        => 'products/vela-salvia-romero.png',
                'category_ids'     => array_filter([$velasCategory?->id]),
            ],
            [
                'title'            => 'Vela Aromática Lemongrass & Jengibre',
                'description'      => 'Vela fresca para repelencia natural de insectos y frescura.',
                'long_description' => 'Notas cítricas punzantes que purifican el aire de la cocina o terraza de manera limpia.',
                'ingredients'      => 'Cera de Soja, Esencia de Lemongrass, Jengibre',
                'price'            => 13500,
                'image_url'        => 'products/vela-lemongrass.png',
                'category_ids'     => array_filter([$velasCategory?->id]),
            ],
            [
                'title'            => 'Vela Masaje Botánico Vainilla & Almendras',
                'description'      => 'Vela tibia cuyo aceite derretido se aplica sobre la piel.',
                'long_description' => 'Bajo punto de fusión. Enriquecida con manteca de karité y aceite de coco para hidratación profunda.',
                'ingredients'      => 'Cera de Soja, Manteca de Karité, Aceite de Almendras',
                'price'            => 17000,
                'image_url'        => 'products/vela-masaje.png',
                'category_ids'     => array_filter([$velasCategory?->id]),
            ],
            [
                'title'            => 'Vela Cera de Palma Selva Negra',
                'description'      => 'Vela con textura cristalizada única y aroma a frutos rojos.',
                'long_description' => 'La cera de palma crea patrones geométrica al solidificar. Aroma intenso y duradero.',
                'ingredients'      => 'Cera de Palma Sustentable, Frutos Rojos',
                'price'            => 15000,
                'image_url'        => 'products/vela-selva-negra.png',
                'category_ids'     => array_filter([$velasCategory?->id]),
            ],

            // ==================== DIFUSORES (28-36) ====================
            [
                'title'            => 'Difusor de Varillas Lavanda & Romero',
                'description'      => 'Difusor ambiental de 250ml con varillas de rattán natural.',
                'long_description' => 'Mantiene una aromatización constante en salas y dormitorios durante más de 60 días seguidos.',
                'ingredients'      => 'Aceites Esenciales, Alcohol de Cereal, Varillas Rattán',
                'price'            => 21000,
                'image_url'        => 'products/difusor-lavanda.png',
                'category_ids'     => array_filter([$difusoresCategory?->id]),
            ],
            [
                'title'            => 'Difusor de Varillas Citrus & Verbena',
                'description'      => 'Difusor refrescante e higienizante para oficinas y accesos.',
                'long_description' => 'Aroma vigorizante a lima, verbena y piel de pomelo rosa. Disimula malos olores eficazmente.',
                'ingredients'      => 'Esencia de Verbena, Pomelo Rosa, Alcohol',
                'price'            => 21000,
                'image_url'        => 'products/difusor-citrus.png',
                'category_ids'     => array_filter([$difusoresCategory?->id]),
            ],
            [
                'title'            => 'Difusor Ultrasónico Madera Clara',
                'description'      => 'Aparato difusor de bruma fría por ultrasonido con luz LED.',
                'long_description' => 'Capacidad de 300ml, temporizador programable y apilado automático de seguridad al agotarse el agua.',
                'ingredients'      => 'Componentes Electrónicos, Plástico Libre de BPA',
                'price'            => 45000,
                'image_url'        => 'products/difusor-ultrasonico.png',
                'category_ids'     => array_filter([$difusoresCategory?->id]),
            ],
            [
                'title'            => 'Difusor de Varillas Flor de Loto & Bambú',
                'description'      => 'Aromatizador sereno para ambientes de lectura y descanso.',
                'long_description' => 'Fragancia verde acuática de sutil permanencia. Incluye 8 varillas de fibra negra de alta absorción.',
                'ingredients'      => 'Esencia Loto, Bambú, Base Hidroalcohólica',
                'price'            => 22000,
                'image_url'        => 'products/difusor-bambu.png',
                'category_ids'     => array_filter([$difusoresCategory?->id]),
            ],
            [
                'title'            => 'Difusor de Cerámica para Velita Noche',
                'description'      => 'Quemador tradicional de aceites esenciales mediante calor.',
                'long_description' => 'Pieza artesanal de cerámica esmaltada. Se utiliza colocando agua y gotas de aceite esencial en la copa superior.',
                'ingredients'      => 'Cerámica Artesanal',
                'price'            => 12500,
                'image_url'        => 'products/difusor-ceramica.png',
                'category_ids'     => array_filter([$difusoresCategory?->id]),
            ],
            [
                'title'            => 'Difusor de Varillas Jazmín Persa',
                'description'      => 'Difusor de fragancia dulce e intemporal para salones.',
                'long_description' => 'Esencia concentrada de flores blancas de jazmín recogidas al amanecer.',
                'ingredients'      => 'Jazmín Persa, Solvente Vegetal, Varillas',
                'price'            => 21500,
                'image_url'        => 'products/difusor-jazmin.png',
                'category_ids'     => array_filter([$difusoresCategory?->id]),
            ],
            [
                'title'            => 'Difusor de Auto Medallón de Madera',
                'description'      => 'Aromatizador para vehículo en soporte de madera noble.',
                'long_description' => 'Se cuelga del espejo retrovisor. Absorbe el aceite y lo libera de manera gradual con el aire.',
                'ingredients'      => 'Madera de Lenga, Aceites Cítricos',
                'price'            => 8500,
                'image_url'        => 'products/difusor-auto.png',
                'category_ids'     => array_filter([$difusoresCategory?->id]),
            ],
            [
                'title'            => 'Difusor de Varillas Ámbar & Especias',
                'description'      => 'Difusor con notas envolventes de madera y clavo.',
                'long_description' => 'Especialmente recomendado para vestir de elegancia salones grandes y recibidores.',
                'ingredients'      => 'Ámbar, Canela, Clavo, Solvente Orgánico',
                'price'            => 23000,
                'image_url'        => 'products/difusor-ambar.png',
                'category_ids'     => array_filter([$difusoresCategory?->id]),
            ],
            [
                'title'            => 'Difusor Pasivo Piedras Volcánicas',
                'description'      => 'Set de rocas porosas volcánicas con contenedor de lata.',
                'long_description' => 'Se impregnan unas gotas de aceite sobre las rocas de basalto para una difución natural sin agua ni electricidad.',
                'ingredients'      => 'Piedra Volcánica Basáltica, Lata Aluminio',
                'price'            => 16500,
                'image_url'        => 'products/difusor-piedras.png',
                'category_ids'     => array_filter([$difusoresCategory?->id]),
            ],

            // ==================== KITS Y COMBOS (37-44) ====================
            [
                'title'            => 'Kit Sahumo Sagrado Completo',
                'description'      => 'Set para limpiezas profundas de hogar y cristales.',
                'long_description' => 'Incluye sahumador cerámico artesanal, atado de salvia blanca, resina de copal, carbones vegetales y guía instructiva.',
                'ingredients'      => 'Salvia Blanca, Copal, Carbón, Cerámica',
                'price'            => 28000,
                'image_url'        => 'products/kit-sahumo.png',
                'category_ids'     => array_filter([$kitsCategory?->id]),
            ],
            [
                'title'            => 'Combo Armonización Total',
                'description'      => 'Kit de Spray Áurico Calma + Vela de Soja Lavanda.',
                'long_description' => 'La combinación perfecta para crear un ritual nocturno de desenchufe digital y calma absoluta.',
                'ingredients'      => 'Dúo Holístico Lavanda',
                'price'            => 26000,
                'image_url'        => 'products/combo-armonizacion.png',
                'category_ids'     => array_filter([$kitsCategory?->id]),
            ],
            [
                'title'            => 'Set Cristales 7 Chakras & Cuenco',
                'description'      => 'Kit de piedras naturales con cuenco de cuarzo mini.',
                'long_description' => '7 gemas auténticas (Amatista, Sodalita, Cuarzo Verde, etc.) para meditación y alineación de puntos energéticos.',
                'ingredients'      => 'Cristales Varios, Cuenco de Cristal',
                'price'            => 32000,
                'image_url'        => 'products/kit-7chakras.png',
                'category_ids'     => array_filter([$kitsCategory?->id]),
            ],
            [
                'title'            => 'Kit Rituales de Luna Llena',
                'description'      => 'Caja temática con libreta, vela intencionada y spray.',
                'long_description' => 'Diseñado para acompañar tus siembras de intención y soltar patrones durante la fase de luna llena.',
                'ingredients'      => 'Vela, Spray, Papel Semilla, Palo Santo',
                'price'            => 31000,
                'image_url'        => 'products/kit-luna-llena.png',
                'category_ids'     => array_filter([$kitsCategory?->id]),
            ],
            [
                'title'            => 'Combo Inicio Aromaterapia',
                'description'      => 'Difusor cerámico + 3 aceites esenciales puros.',
                'long_description' => 'Incluye aceites esenciales de Lavanda, Naranja Dulce y Árbol de Té de 10ml cada uno.',
                'ingredients'      => 'Aceites Puros 10ml, Hornillo Cerámica',
                'price'            => 29000,
                'image_url'        => 'products/combo-inicio.png',
                'category_ids'     => array_filter([$kitsCategory?->id]),
            ],
            [
                'title'            => 'Set Regalo Bienestar & Mimo',
                'description'      => 'Caja de madera con jabón botánico, vela y perfume.',
                'long_description' => 'Presentación lista para obsequiar con tarjeta personalizable para eventos especiales.',
                'ingredients'      => 'Jabón Karité, Vela Soja, Perfume Roll-on',
                'price'            => 35000,
                'image_url'        => 'products/kit-regalo.png',
                'category_ids'     => array_filter([$kitsCategory?->id]),
            ],
            [
                'title'            => 'Kit Abundancia & Prosperidad 21 Días',
                'description'      => 'Programa de intencionamiento con 21 velitas y spray.',
                'long_description' => 'Incluye rutina diaria estructurada con oraciones y decretos para activar la energía financiera.',
                'ingredients'      => '21 Velas de Miel, Spray Citrino, Guía',
                'price'            => 27500,
                'image_url'        => 'products/kit-abundancia.png',
                'category_ids'     => array_filter([$kitsCategory?->id]),
            ],
            [
                'title'            => 'Combo Auto Cuidado & Spa en Casa',
                'description'      => 'Sales de baño con cristales + Vela de masaje.',
                'long_description' => 'Transforma el cuarto de baño en un centro de relajación con sales del Himalaya enriquecidas.',
                'ingredients'      => 'Sal Himalaya, Aceite Esencial, Vela',
                'price'            => 24000,
                'image_url'        => 'products/combo-spa.png',
                'category_ids'     => array_filter([$kitsCategory?->id]),
            ],

            // ==================== REFILL (45-50) ====================
            [
                'title'            => 'Refill Spray Áurico Calma 500ml',
                'description'      => 'Envase económico de recarga para tu frasco atómico.',
                'long_description' => 'Botella Doypack o PET reciclado de medio litro. Rinde más de 4 recargas completas del envase estándar.',
                'ingredients'      => 'Lavanda, Manzanilla, Agua Purificada',
                'price'            => 29000,
                'image_url'        => 'products/refill-calma.png',
                'category_ids'     => array_filter([$refillCategory?->id]),
            ],
            [
                'title'            => 'Refill Spray Áurico Proteccion 500ml',
                'description'      => 'Repuesto ecológico de bruma protectora.',
                'long_description' => 'Misma fórmula concentrada en formato sustentable con reducción de un 70% de plástico.',
                'ingredients'      => 'Ruda, Romero, Sándalo',
                'price'            => 29000,
                'image_url'        => 'products/refill-proteccion.png',
                'category_ids'     => array_filter([$refillCategory?->id]),
            ],
            [
                'title'            => 'Refill Difusor de Varillas Citrus 500ml',
                'description'      => 'Recarga de aromatizador ambiental con líquido concentrado.',
                'long_description' => 'Permite rellenar tu difusor de vidrio dos veces. Incluye repuesto de 8 varillas de rattán de regalo.',
                'ingredients'      => 'Esencia Verbena, Pomelo, Alcohol',
                'price'            => 33000,
                'image_url'        => 'products/refill-difusor-citrus.png',
                'category_ids'     => array_filter([$refillCategory?->id]),
            ],
            [
                'title'            => 'Refill Difusor Lavanda & Romero 500ml',
                'description'      => 'Líquido de repuesto para mantener la fragancia viva.',
                'long_description' => 'Mantén tus espacios continuamente perfumados rellenando tu envase original.',
                'ingredients'      => 'Aceites Esenciales Lavanda y Romero',
                'price'            => 33000,
                'image_url'        => 'products/refill-difusor-lavanda.png',
                'category_ids'     => array_filter([$refillCategory?->id]),
            ],
            [
                'title'            => 'Refill Jabón Líquido Aromatizado 1Litro',
                'description'      => 'Repuesto de jabón de manos suave enriquecido con aceites.',
                'long_description' => 'Fórmula biodegradable limpia sin resecar. Aroma a té verde y bergamota.',
                'ingredients'      => 'Té Verde, Bergamota, Glicerina Vegetal',
                'price'            => 18000,
                'image_url'        => 'products/refill-jabon.png',
                'category_ids'     => array_filter([$refillCategory?->id]),
            ],
            [
                'title'            => 'Refill Aceite Esencial de Pura Lavanda 50ml',
                'description'      => 'Frasco gotero formato profesional para quemadores y difusores.',
                'long_description' => 'Aceite 100% puro destilado por arrastre de vapor. Calidad terapéutica.',
                'ingredients'      => 'Aceite Esencial Lavandula Angustifolia 100%',
                'price'            => 25000,
                'image_url'        => 'products/refill-aceite-lavanda.png',
                'category_ids'     => array_filter([$refillCategory?->id]),
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | 3. Persistencia e Integración de Relaciones
        |--------------------------------------------------------------------------
        */
        foreach ($products as $productData) {
            $slug = Str::slug($productData['title']);

            $product = Product::updateOrCreate(
                [
                    'slug' => $slug,
                ],
                [
                    'title'            => $productData['title'],
                    'description'      => $productData['description'],
                    'long_description' => $productData['long_description'],
                    'ingredients'      => $productData['ingredients'],
                    'price'            => $productData['price'],
                    'image_url'        => $productData['image_url'],
                    'active'           => true,
                ]
            );

            // Fusionar la categoría específica del producto con "Todos los productos"
            $targetCategories = $productData['category_ids'];

            if ($allCategory) {
                $targetCategories[] = $allCategory->id;
            }

            // Asignar categorías en tabla pivote evitando duplicados
            $product->categories()->sync(array_unique($targetCategories));
        }
    }
}
