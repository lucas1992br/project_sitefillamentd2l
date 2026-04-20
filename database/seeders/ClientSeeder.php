<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            [
                'name' => 'AeroTech Systems',
                'industry' => 'Aerospace',
                'testimonial' => 'Precision Machining consistently delivers flight-critical components on time and to the tightest tolerances. A truly reliable partner.',
                'contact_name' => 'James Harrington',
                'contact_role' => 'Supply Chain Director',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Petrobras Drilling',
                'industry' => 'Oil & Gas',
                'testimonial' => 'Their ability to machine exotic alloys to demanding specs for deepwater equipment is unmatched in the region.',
                'contact_name' => 'Ana Lima',
                'contact_role' => 'Procurement Manager',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Volkswagen do Brasil',
                'industry' => 'Automotive',
                'testimonial' => 'Fast turnaround on prototype tooling and consistent quality across high-volume runs.',
                'contact_name' => 'Klaus Weber',
                'contact_role' => 'Manufacturing Engineer',
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'MedAlpha Devices',
                'industry' => 'Medical',
                'testimonial' => 'The cleanroom machining capability and full traceability records give us the confidence we need for regulatory submissions.',
                'contact_name' => 'Sophie Martin',
                'contact_role' => 'Quality Director',
                'is_featured' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($clients as $data) {
            Client::firstOrCreate(['name' => $data['name']], $data);
        }
    }
}
