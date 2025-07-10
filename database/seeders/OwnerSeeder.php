<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Owner;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $owners = [
            [
                'name' => 'Ahmed Al-Rashid',
                'email' => 'ahmed.rashid@constructco.sa',
                'phone_number' => '+966 50 123 4567',
                'company' => 'Al-Rashid Construction Co.',
                'address' => '123 King Fahd Road, Al-Olaya District',
                'city' => 'Riyadh',
                'country' => 'Saudi Arabia',
                'preferred_language' => 'ar',
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@midwestexcavation.com',
                'phone_number' => '+1 555 234 5678',
                'company' => 'Midwest Excavation LLC',
                'address' => '456 Industrial Blvd, Suite 200',
                'city' => 'Chicago',
                'country' => 'United States',
                'preferred_language' => 'en',
            ],
            [
                'name' => 'Carlos Mendez',
                'email' => 'carlos.mendez@construccionesmexico.mx',
                'phone_number' => '+52 55 3456 7890',
                'company' => 'Construcciones México SA',
                'address' => 'Av. Insurgentes Sur 1234, Col. Del Valle',
                'city' => 'Mexico City',
                'country' => 'Mexico',
                'preferred_language' => 'es',
            ],
            [
                'name' => 'Emma Thompson',
                'email' => 'emma.thompson@ukdrilling.co.uk',
                'phone_number' => '+44 20 7890 1234',
                'company' => 'UK Drilling Solutions Ltd',
                'address' => '789 Canary Wharf, Tower Hamlets',
                'city' => 'London',
                'country' => 'United Kingdom',
                'preferred_language' => 'en',
            ],
            [
                'name' => 'Hans Mueller',
                'email' => 'hans.mueller@deutschebau.de',
                'phone_number' => '+49 30 4567 8901',
                'company' => 'Deutsche Bau GmbH',
                'address' => 'Potsdamer Platz 10, Mitte',
                'city' => 'Berlin',
                'country' => 'Germany',
                'preferred_language' => 'de',
            ],
            [
                'name' => 'Yuki Tanaka',
                'email' => 'yuki.tanaka@tokyoconstruction.jp',
                'phone_number' => '+81 3 5678 9012',
                'company' => 'Tokyo Construction Inc.',
                'address' => '1-2-3 Shibuya, Shibuya-ku',
                'city' => 'Tokyo',
                'country' => 'Japan',
                'preferred_language' => 'ja',
            ],
            [
                'name' => 'Marco Rossi',
                'email' => 'marco.rossi@italiacostruzioni.it',
                'phone_number' => '+39 06 6789 0123',
                'company' => 'Italia Costruzioni SRL',
                'address' => 'Via del Corso 100, Centro Storico',
                'city' => 'Rome',
                'country' => 'Italy',
                'preferred_language' => 'it',
            ],
            [
                'name' => 'Pierre Dubois',
                'email' => 'pierre.dubois@francebtp.fr',
                'phone_number' => '+33 1 7890 1234',
                'company' => 'France BTP SARL',
                'address' => '50 Avenue des Champs-Élysées',
                'city' => 'Paris',
                'country' => 'France',
                'preferred_language' => 'fr',
            ],
            [
                'name' => 'John Smith',
                'email' => null,
                'phone_number' => '+1 416 890 1234',
                'company' => null,
                'address' => '123 Main Street',
                'city' => 'Toronto',
                'country' => 'Canada',
                'preferred_language' => 'en',
            ],
            [
                'name' => 'Anonymous Owner',
                'email' => null,
                'phone_number' => null,
                'company' => null,
                'address' => null,
                'city' => null,
                'country' => null,
                'preferred_language' => null,
            ],
        ];

        foreach ($owners as $ownerData) {
            Owner::create($ownerData);
        }
    }
}
