<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\Owner;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample categories
        $categories = [
            ['name' => 'Hydraulic Breakers', 'description' => 'Heavy-duty hydraulic breaking equipment'],
            ['name' => 'Drilling Equipment', 'description' => 'Professional drilling machines and tools'],
            ['name' => 'Construction Tools', 'description' => 'Construction and mining equipment'],
        ];

        foreach ($categories as $categoryData) {
            ProductCategory::firstOrCreate(
                ['name' => $categoryData['name']],
                $categoryData
            );
        }

        // Create sample products
        $hydraulicBreaker = ProductCategory::where('name', 'Hydraulic Breakers')->first();

        $products = [
            [
                'name' => 'SB45 Hydraulic Breaker',
                'model_number' => 'SB45-2024',
                'category_id' => $hydraulicBreaker->id,
                'description' => 'Professional hydraulic breaker for medium to heavy-duty applications. Features advanced impact technology and durable construction.',
                'price' => 25000.00,
                'body_weight' => 65,
                'operating_weight' => 90,
                'overall_length' => 1071,
                'overall_width' => 191,
                'overall_height' => 424,
                'required_oil_flow' => '20 ~ 40',
                'operating_pressure' => '90 ~ 120',
                'impact_rate_std' => '700 ~ 1,200',
                'impact_rate_soft_rock' => '~',
                'hose_diameter' => '3/8, 1/2',
                'rod_diameter' => 45,
                'applicable_carrier' => '1.2 ~ 3',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'SB81 Heavy Duty Breaker',
                'model_number' => 'SB81-2024',
                'category_id' => $hydraulicBreaker->id,
                'description' => 'Heavy-duty hydraulic breaker for demanding applications. Built for continuous operation.',
                'price' => 45000.00,
                'body_weight' => 120,
                'operating_weight' => 150,
                'overall_length' => 1250,
                'overall_width' => 220,
                'overall_height' => 480,
                'required_oil_flow' => '40 ~ 80',
                'operating_pressure' => '120 ~ 160',
                'impact_rate_std' => '600 ~ 1,000',
                'impact_rate_soft_rock' => '~',
                'hose_diameter' => '1/2, 3/4',
                'rod_diameter' => 65,
                'applicable_carrier' => '3 ~ 8',
                'is_active' => true,
                'is_featured' => true,
            ]
        ];

        foreach ($products as $productData) {
            Product::firstOrCreate(
                ['model_number' => $productData['model_number']],
                $productData
            );
        }

        // Create sample owners
        $owners = [
            [
                'full_name' => 'John Smith',
                'email' => 'john@abconstruction.com',
                'phone' => '+1-555-0123',
                'company' => 'ABC Construction Co.',
                'address' => '123 Main St',
                'city' => 'New York',
                'country' => 'United States',
                'preferred_language' => 'en',
            ],
            [
                'full_name' => 'Sarah Johnson',
                'email' => 'sarah@miningsolutions.com',
                'phone' => '+1-555-0456',
                'company' => 'Mining Solutions Ltd.',
                'address' => '456 Industrial Blvd',
                'city' => 'Houston',
                'country' => 'United States',
                'preferred_language' => 'en',
            ]
        ];

        foreach ($owners as $ownerData) {
            Owner::firstOrCreate(
                ['email' => $ownerData['email']],
                $ownerData
            );
        }

        $this->command->info('Sample data created successfully!');
    }
}
