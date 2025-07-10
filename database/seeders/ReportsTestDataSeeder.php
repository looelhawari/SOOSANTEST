<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Owner;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\SoldProduct;
use Carbon\Carbon;

class ReportsTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@reports.test',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_verified' => true,
        ]);

        // Create CEO user
        $ceo = User::create([
            'name' => 'CEO User',
            'email' => 'ceo@reports.test',
            'password' => bcrypt('password'),
            'role' => 'ceo',
            'is_verified' => true,
        ]);

        // Create employees
        $employees = [];
        for ($i = 1; $i <= 5; $i++) {
            $employees[] = User::create([
                'name' => "Employee $i",
                'email' => "employee$i@reports.test",
                'password' => bcrypt('password'),
                'role' => 'employee',
                'is_verified' => true,
                'created_by' => $admin->id,
            ]);
        }

        // Create product categories
        $categories = [];
        $categoryNames = ['Drilling Equipment', 'Safety Gear', 'Maintenance Tools', 'Electronics', 'Accessories'];
        foreach ($categoryNames as $name) {
            $categories[] = ProductCategory::create([
                'name' => $name,
                'description' => "Category for $name",
                'is_active' => true,
            ]);
        }

        // Create products
        $products = [];
        for ($i = 1; $i <= 20; $i++) {
            $products[] = Product::create([
                'name' => "Product $i",
                'model' => "MODEL-$i",
                'description' => "Description for product $i",
                'category_id' => $categories[array_rand($categories)]->id,
                'price' => rand(100, 5000),
                'stock_quantity' => rand(10, 100),
                'is_active' => true,
                'created_by' => $admin->id,
            ]);
        }

        // Create owners
        $owners = [];
        $cities = ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix'];
        $countries = ['USA', 'Canada', 'Mexico', 'UK', 'Germany'];
        
        for ($i = 1; $i <= 50; $i++) {
            $owners[] = Owner::create([
                'name' => "Owner $i",
                'email' => "owner$i@test.com",
                'phone' => "+1-555-" . str_pad($i, 4, '0', STR_PAD_LEFT),
                'city' => $cities[array_rand($cities)],
                'country' => $countries[array_rand($countries)],
                'created_by' => $employees[array_rand($employees)]->id,
            ]);
        }

        // Create sold products with realistic date distribution
        $now = Carbon::now();
        $dates = [];
        
        // Generate sales for the last 90 days
        for ($i = 0; $i < 90; $i++) {
            $date = $now->copy()->subDays($i);
            $salesCount = rand(1, 8); // 1-8 sales per day
            
            for ($j = 0; $j < $salesCount; $j++) {
                $product = $products[array_rand($products)];
                $owner = $owners[array_rand($owners)];
                $employee = $employees[array_rand($employees)];
                
                $purchasePrice = $product->price * 0.7; // 70% of retail price
                $sellingPrice = $product->price + rand(-200, 500); // Some variation
                
                SoldProduct::create([
                    'product_id' => $product->id,
                    'owner_id' => $owner->id,
                    'sold_by' => $employee->id,
                    'purchase_price' => $purchasePrice,
                    'selling_price' => $sellingPrice,
                    'profit' => $sellingPrice - $purchasePrice,
                    'sold_at' => $date->copy()->addHours(rand(8, 18)), // Sales during business hours
                    'created_by' => $employee->id,
                ]);
            }
        }

        $this->command->info('Reports test data seeded successfully!');
        $this->command->info('Admin login: admin@reports.test / password');
        $this->command->info('CEO login: ceo@reports.test / password');
        $this->command->info('Created ' . count($products) . ' products');
        $this->command->info('Created ' . count($owners) . ' owners');
        $this->command->info('Created approximately ' . SoldProduct::count() . ' sales records');
    }
}
