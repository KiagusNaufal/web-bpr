<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrNew(['email' => env('ADMIN_EMAIL', 'admin@bpr.test')]);
        $admin->forceFill([
            'name' => 'Administrator',
            'password' => env('ADMIN_PASSWORD', 'ganti-password-ini'),
            'role' => UserRole::SuperAdmin,
            'is_active' => true,
        ])->save();

        $this->call(ContentSeeder::class);
    }
}
