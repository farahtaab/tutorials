<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Database\Seeders\IfixitSeeder; 
use Database\Seeders\GuideSeeder; 

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear un usuario de prueba
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Llamar al IfixitSeeder para poblar la tabla ifixits
        $this->call(IfixitSeeder::class);

        // Llamar al GuideSeeder para poblar la tabla guides
        $this->call(GuideSeeder::class);
    }
}
