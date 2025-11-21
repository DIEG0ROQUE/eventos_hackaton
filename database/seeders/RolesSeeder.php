<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'estudiante',
                'description' => 'Estudiante participante en eventos',
            ],
            [
                'name' => 'admin',
                'description' => 'Administrador del sistema',
            ],
            [
                'name' => 'juez',
                'description' => 'Juez evaluador de proyectos',
            ],
            [
                'name' => 'asesor',
                'description' => 'Asesor de equipos',
            ],
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(
                ['name' => $roleData['name']],
                ['description' => $roleData['description']]
            );
        }

        $this->command->info('✅ Roles creados exitosamente');
    }
}