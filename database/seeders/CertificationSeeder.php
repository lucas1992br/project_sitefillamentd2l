<?php

namespace Database\Seeders;

use App\Models\Certification;
use Illuminate\Database\Seeder;

class CertificationSeeder extends Seeder
{
    public function run(): void
    {
        $certs = [
            [
                'name' => 'ISO 9001:2015',
                'issuer' => 'Bureau Veritas',
                'certificate_number' => 'BV-QMS-0042-2020',
                'issued_at' => '2020-06-01',
                'expires_at' => '2026-06-01',
                'description' => 'Quality Management System certification covering all machining and fabrication processes.',
                'sort_order' => 1,
            ],
            [
                'name' => 'AS9100 Rev D',
                'issuer' => 'DNV GL',
                'certificate_number' => 'DNV-AS9100-0012',
                'issued_at' => '2021-03-15',
                'expires_at' => '2027-03-15',
                'description' => 'Aerospace Quality Management System — authorises supply to aviation and defence OEMs.',
                'sort_order' => 2,
            ],
            [
                'name' => 'ISO 45001:2018',
                'issuer' => 'SGS',
                'certificate_number' => 'SGS-OHS-2019-0088',
                'issued_at' => '2019-11-01',
                'expires_at' => '2025-11-01',
                'description' => 'Occupational Health & Safety Management System.',
                'sort_order' => 3,
            ],
        ];

        foreach ($certs as $data) {
            Certification::firstOrCreate(['certificate_number' => $data['certificate_number']], $data);
        }
    }
}
