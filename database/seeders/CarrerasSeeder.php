<?php

namespace Database\Seeders;

use App\Models\Carrera;
use Illuminate\Database\Seeder;

class CarrerasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carreras = [
            [
                'nombre' => 'Ingeniería en Sistemas Computacionales',
                'clave' => 'ISC',
                'activo' => true,
            ],
            [
                'nombre' => 'Ingeniería en Gestión Empresarial',
                'clave' => 'IGE',
                'activo' => true,
            ],
            [
                'nombre' => 'Ingeniería Industrial',
                'clave' => 'IND',
                'activo' => true,
            ],
            [
                'nombre' => 'Ingeniería en Electrónica',
                'clave' => 'IEL',
                'activo' => true,
            ],
            [
                'nombre' => 'Ingeniería Mecatrónica',
                'clave' => 'IMT',
                'activo' => true,
            ],
            [
                'nombre' => 'Ingeniería en Mecánica',
                'clave' => 'IME',
                'activo' => true,
            ],
            [
                'nombre' => 'Arquitectura',
                'clave' => 'ARQ',
                'activo' => true,
            ],
            [
                'nombre' => 'Ingeniería Civil',
                'clave' => 'ICI',
                'activo' => true,
            ],
        ];

        foreach ($carreras as $carreraData) {
            Carrera::firstOrCreate(
                ['clave' => $carreraData['clave']],
                $carreraData
            );
        }

        $this->command->info('✅ Carreras creadas exitosamente');
    }
}