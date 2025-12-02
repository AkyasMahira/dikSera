<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DefaultUsersSeeder extends Seeder
{
    public function run()
    {
        // Admin
        if (!User::where('email', 'admin@gmail.com')->exists()) {
            User::create([
                'name'     => 'Admin DIK SERA',
                'email'    => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'role'     => User::ROLE_ADMIN,
            ]);
        }

        // Pewawancara
        if (!User::where('email', 'pewawancara@gmail.com')->exists()) {
            User::create([
                'name'     => 'Pewawancara DIK SERA',
                'email'    => 'pewawancara@gmail.com',
                'password' => Hash::make('admin123'),
                'role'     => User::ROLE_PEWAWANCARA,
            ]);
        }
    }
}
