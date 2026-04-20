<?php

namespace Database\Seeders;

use App\Models\PortfolioItem;
use Illuminate\Database\Seeder;

class PortfolioItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'Aerospace Bracket — Ti-6Al-4V',
                'subtitle' => 'Flight-critical component',
                'description' => '<p>5-axis milled titanium bracket for avionics bay mounting. Tolerance ±0.003 mm, anodised class 2.</p>',
                'category' => 'milling',
                'material' => 'Titanium Ti-6Al-4V',
                'tolerance' => '±0.003 mm',
                'client_name' => 'Aerospace OEM',
                'sort_order' => 1,
                'is_featured' => true,
            ],
            [
                'title' => 'Hydraulic Manifold Block',
                'subtitle' => 'Oil & Gas sector',
                'description' => '<p>316L stainless steel manifold with 24 cross-drillings, pressure-tested to 350 bar.</p>',
                'category' => 'milling',
                'material' => 'Stainless 316L',
                'tolerance' => '±0.01 mm',
                'client_name' => 'Oil & Gas OEM',
                'sort_order' => 2,
                'is_featured' => true,
            ],
            [
                'title' => 'Drive Shaft Assembly',
                'subtitle' => 'Automotive powertrain',
                'description' => '<p>CNC-turned and ground EN36C case-hardened drive shaft, surface roughness Ra 0.4 µm.</p>',
                'category' => 'turning',
                'material' => 'EN36C Steel',
                'tolerance' => '±0.005 mm',
                'client_name' => 'Auto Tier 1',
                'sort_order' => 3,
                'is_featured' => false,
            ],
            [
                'title' => 'Structural Weldment Frame',
                'subtitle' => 'Mining equipment',
                'description' => '<p>Heavy-duty welded S355 structural frame, fully NDT inspected and hot-dip galvanised.</p>',
                'category' => 'welding',
                'material' => 'S355 Steel',
                'tolerance' => '±1 mm',
                'client_name' => 'Mining Equipment Co.',
                'sort_order' => 4,
                'is_featured' => false,
            ],
            [
                'title' => 'Medical Implant Housing',
                'subtitle' => 'ISO 13485 compliant',
                'description' => '<p>Ultra-clean room machined 6061-T6 aluminium housing for implantable device. Electropolished finish.</p>',
                'category' => 'milling',
                'material' => 'Aluminium 6061-T6',
                'tolerance' => '±0.002 mm',
                'client_name' => 'MedTech Corp',
                'sort_order' => 5,
                'is_featured' => true,
            ],
            [
                'title' => 'Pump Impeller',
                'subtitle' => 'Fluid dynamics optimised',
                'description' => '<p>Investment-cast then finish-machined Duplex 2205 impeller for aggressive slurry service.</p>',
                'category' => 'turning',
                'material' => 'Duplex 2205',
                'tolerance' => '±0.02 mm',
                'client_name' => 'Pump Manufacturer',
                'sort_order' => 6,
                'is_featured' => false,
            ],
        ];

        foreach ($items as $data) {
            PortfolioItem::firstOrCreate(['title' => $data['title']], $data);
        }
    }
}
