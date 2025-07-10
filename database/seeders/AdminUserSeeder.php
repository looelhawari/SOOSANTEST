<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if it doesn't exist
        $adminUser = User::firstOrCreate(
            ['email' => 'koks@gmail.com'],
            [
                'name' => 'Koks',
                'email' => 'koks@gmail.com',
                'password' => Hash::make('koks123456'),
                'role' => 'admin',
                'is_verified' => true,
                'email_verified_at' => now(),
                'phone_number' => '01144689191',
                'image_url' => null,
            ]
        );

        $this->command->info('Admin user created/updated successfully!');
        $this->command->info('Email: koks@gmail.com');
        $this->command->info('Password: koks123456');
    }
}
