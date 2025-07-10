<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create categories
        $category1 = ProductCategory::firstOrCreate(['name' => 'Hydraulic Breakers']);
        $category2 = ProductCategory::firstOrCreate(['name' => 'Demolition Tools']);

        // Sample products with typical drilling equipment specifications
        $products = [
            [
                'model_name' => 'SB20E',
                'line' => 'SB Series',
                'type' => 'Light Breaker',
                'category_id' => $category1->id,
                'body_weight' => '130 kg',
                'operating_weight' => '145 kg',
                'overall_length' => '1890 mm',
                'overall_width' => '310 mm',
                'overall_height' => '580 mm',
                'required_oil_flow' => '20-35 L/min',
                'operating_pressure' => '105-140 bar',
                'impact_rate' => '350-650 BPM',
                'impact_rate_soft_rock' => '500-850 BPM',
                'hose_diameter' => '12.7 mm',
                'rod_diameter' => '95 mm',
                'applicable_carrier' => '1.5-4 ton excavator',
                'image_url' => 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=400&h=300&fit=crop',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'model_name' => 'SB40',
                'line' => 'SB Series',
                'type' => 'Medium Breaker',
                'category_id' => $category1->id,
                'body_weight' => '280 kg',
                'operating_weight' => '310 kg',
                'overall_length' => '2150 mm',
                'overall_width' => '390 mm',
                'overall_height' => '680 mm',
                'required_oil_flow' => '35-60 L/min',
                'operating_pressure' => '130-160 bar',
                'impact_rate' => '450-750 BPM',
                'impact_rate_soft_rock' => '600-950 BPM',
                'hose_diameter' => '19 mm',
                'rod_diameter' => '120 mm',
                'applicable_carrier' => '4-8 ton excavator',
                'image_url' => 'https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?w=400&h=600&fit=crop',
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'model_name' => 'SB70',
                'line' => 'SB Series',
                'type' => 'Heavy Breaker',
                'category_id' => $category1->id,
                'body_weight' => '520 kg',
                'operating_weight' => '570 kg',
                'overall_length' => '2450 mm',
                'overall_width' => '480 mm',
                'overall_height' => '780 mm',
                'required_oil_flow' => '60-90 L/min',
                'operating_pressure' => '140-170 bar',
                'impact_rate' => '350-650 BPM',
                'impact_rate_soft_rock' => '500-800 BPM',
                'hose_diameter' => '25 mm',
                'rod_diameter' => '140 mm',
                'applicable_carrier' => '8-15 ton excavator',
                'image_url' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=300&h=500&fit=crop',
                'is_active' => true,
                'is_featured' => true,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
