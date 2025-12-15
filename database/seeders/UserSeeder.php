<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear un ADMIN fijo para pruebas
        User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // La contraseña es 'password'
            'role' => 'admin',
        ]);

        // 2. Crear un MANAGER fijo (sin equipo asignado inicialmente)
        User::factory()->create([
            'name' => 'Manager General',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
        ]);

        // 3. Crear un ÁRBITRO fijo
        User::factory()->create([
            'name' => 'Árbitro Principal',
            'email' => 'arbitre@example.com',
            'password' => Hash::make('password'),
            'role' => 'arbitre',
        ]);

        // 4. Crear 10 Árbitros aleatorios más
        User::factory(10)->create([
            'role' => 'arbitre',
        ]);
        
        // Opcional: Crear algunos usuarios normales o managers extra
        User::factory(5)->create([
            'role' => 'manager',
        ]);
    }
}