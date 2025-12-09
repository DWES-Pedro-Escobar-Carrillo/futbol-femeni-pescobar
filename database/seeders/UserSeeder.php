<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@futboldwes.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        
        // Un àrbitre d'exemple
        User::create([
            'name' => 'Arbitre Principal',
            'email' => 'arbitre@futboldwes.com',
            'password' => Hash::make('password'),
            'role' => 'arbitre',
        ]);
    }
}