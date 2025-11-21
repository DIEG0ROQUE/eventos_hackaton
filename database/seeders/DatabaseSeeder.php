<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 Iniciando seeders...');
        
        // Orden de ejecución
        $this->call([
            RolesSeeder::class,
            CarrerasSeeder::class,
            UsersSeeder::class,
            // EventosSeeder::class, // Lo crearemos después
        ]);
        
        $this->command->info('');
        $this->command->info('✨ ¡Base de datos poblada exitosamente!');
        $this->command->info('');
        $this->command->info('🔐 Credenciales de acceso:');
        $this->command->info('   Admin: admin@itoaxaca.edu.mx / password');
        $this->command->info('   Juez: juez@itoaxaca.edu.mx / password');
        $this->command->info('   Estudiante: angel@itoaxaca.edu.mx / password');
    }
}