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
            ['email' => 'admin@tateta-geo.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('admin123'),
                'role' => 'super_admin',
                'status' => 'active',
                'api_quota' => 999999, // Unlimited quota (optional, bisa diabaikan)
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ Super Admin created: admin@tateta-geo.com / admin123');

        // Create Regular Admin (optional)
        \App\Models\User::updateOrCreate(
            ['email' => 'moderator@tateta-geo.com'],
            [
                'name' => 'Moderator',
                'password' => bcrypt('moderator123'),
                'role' => 'admin',
                'status' => 'active',
                'api_quota' => 999999, // Unlimited quota (optional, bisa diabaikan)
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ Admin created: moderator@tateta-geo.com / moderator123');
    }
}
