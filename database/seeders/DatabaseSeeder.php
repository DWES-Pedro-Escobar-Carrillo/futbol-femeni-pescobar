<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,      // <--- IMPORTANTE: Los usuarios primero
            EstadisSeeder::class,
            EquipsSeeder::class,
            JugadoresSeeder::class,
            PartitsSeeder::class,
        ]);
    }
}