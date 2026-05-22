<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin
        \App\Models\User::updateOrCreate(
            ['email' => 'admin-geo@tateta.samastanuswantara.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('@Tateta-GeoAdmin2026'),
                'role' => 'super_admin',
                'status' => 'active',
                'api_quota' => 999999, // Unlimited quota (optional, bisa diabaikan)
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ Super Admin created: admin@tateta-geo.com / admin123');

    }
}
