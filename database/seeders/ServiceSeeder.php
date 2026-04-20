<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'CNC Turning',
                'subtitle' => 'Rotational Parts',
                'description' => '<p>High-precision CNC turning for cylindrical components. We handle diameters from 5 mm to 500 mm with surface finishes down to Ra 0.4 µm.</p>',
                'icon' => 'cog-6-tooth',
                'sort_order' => 1,
            ],
            [
                'title' => 'CNC Milling',
                'subtitle' => 'Complex Geometries',
                'description' => '<p>3-, 4- and 5-axis milling for prismatic and complex-profile parts. Tolerances to ±0.005 mm on all axes.</p>',
                'icon' => 'wrench-screwdriver',
                'sort_order' => 2,
            ],
            [
                'title' => 'Welding & Fabrication',
                'subtitle' => 'MIG / TIG / Plasma',
                'description' => '<p>Certified welders for structural and precision assemblies in carbon steel, stainless and aluminium. Full NDT inspection available.</p>',
                'icon' => 'fire',
                'sort_order' => 3,
            ],
            [
                'title' => 'Surface Finishing',
                'subtitle' => 'Coating & Treatment',
                'description' => '<p>Anodising, powder coating, electroplating, hard chrome, nitro-carburising and black oxide — all in-house for complete traceability.</p>',
                'icon' => 'sparkles',
                'sort_order' => 4,
            ],
        ];

        foreach ($services as $data) {
            Service::firstOrCreate(['slug' => Str::slug($data['title'])], $data);
        }
    }
}
