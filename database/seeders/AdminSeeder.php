<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::firstOrCreate(
            ['email' => 'admin@bhc.local'],
            [
                'name' => 'BHC Admin',
                'password' => Hash::make('changeme!'),
                'email_verified_at' => now(),
            ],
        );
    }
}
