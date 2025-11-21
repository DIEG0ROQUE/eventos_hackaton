<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuarios de prueba
        $admin = User::firstOrCreate(
            ['email' => 'admin@ejemplo.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
            ]
        );

        $users = [];
        $users[] = User::firstOrCreate(
            ['email' => 'juan.perez@ejemplo.com'],
            [
                'name' => 'Juan Pérez',
                'password' => Hash::make('password'),
            ]
        );

        $users[] = User::firstOrCreate(
            ['email' => 'maria.garcia@ejemplo.com'],
            [
                'name' => 'María García',
                'password' => Hash::make('password'),
            ]
        );

        $users[] = User::firstOrCreate(
            ['email' => 'karla.rocio@ejemplo.com'],
            [
                'name' => 'Karla Rocío',
                'password' => Hash::make('password'),
            ]
        );

        $users[] = User::firstOrCreate(
            ['email' => 'jesus.martinez@ejemplo.com'],
            [
                'name' => 'Jesús Martínez',
                'password' => Hash::make('password'),
            ]
        );

        $users[] = User::firstOrCreate(
            ['email' => 'carlos.ruiz@ejemplo.com'],
            [
                'name' => 'Carlos Ruiz',
                'password' => Hash::make('password'),
            ]
        );

        // Crear evento Hackaton 2025
        $event = Event::create([
            'title' => 'Hackaton 2025',
            'description' => 'Competencia de programación de 48 horas donde equipos desarrollan soluciones innovadoras a problemas reales.',
            'start_date' => now()->addMonth(),
            'end_date' => now()->addMonth()->addDays(2),
            'location' => 'Campus Central - Auditorio Principal',
            'duration_hours' => 48,
            'max_teams' => null,
            'max_team_members' => 5,
            'type' => 'Programación',
            'status' => 'open',
            'prizes' => [
                '$10,000 MXN',
                '$5,000 MXN',
                '$2,500 MXN',
            ],
            'requirements' => [
                'Estudiante Activo',
                'Conocimientos Básicos de Programación',
                'Laptop Personal',
            ],
            'schedule' => [
                [
                    'name' => 'Registro',
                    'date' => '1 - 14 Mar'
                ],
                [
                    'name' => 'Evento',
                    'date' => '15 - 17 de Mar'
                ],
                [
                    'name' => 'Evaluación',
                    'date' => '18 Mar'
                ],
                [
                    'name' => 'Premiación',
                    'date' => '20 Mar'
                ],
            ],
            'resources_url' => 'https://ejemplo.com/recursos',
            'created_by' => $admin->id,
        ]);

        // Crear equipo CodeMasters
        $teamCodeMasters = Team::create([
            'name' => 'CodeMasters',
            'description' => 'Equipo multidisciplinario enfocado en desarrollo de soluciones empresariales',
            'event_id' => $event->id,
            'leader_id' => $users[0]->id,
            'max_members' => 5,
            'status' => 'recruiting',
            'available_roles' => ['Analista de Negocios'],
            'technologies' => ['Laravel', 'React', 'Python'],
        ]);

        // Agregar miembros a CodeMasters
        $teamCodeMasters->addMember($users[0], 'Programador', 'Ing. Software');
        $teamCodeMasters->addMember($users[1], 'Programador', 'Desarrollo Web');
        $teamCodeMasters->addMember($users[2], 'Diseñador', 'Diseño Gráfico');
        $teamCodeMasters->addMember($users[3], 'Analista De Datos', 'Ing. Datos');

        // Crear equipo HackerBoys
        $teamHackerBoys = Team::create([
            'name' => 'HackerBoys',
            'description' => 'Equipo enfocado en desarrollo web y mobile con experiencia en Dart y CSS',
            'event_id' => $event->id,
            'leader_id' => $users[4]->id,
            'max_members' => 5,
            'status' => 'recruiting',
            'available_roles' => ['Analista de Negocios', 'Diseñador', 'Analista de Datos'],
            'technologies' => ['Dart', 'CSS', 'Flutter'],
        ]);

        // Agregar miembros a HackerBoys
        $teamHackerBoys->addMember($users[4], 'Programador', 'Ing. Software');

        // Crear más eventos de ejemplo
        Event::create([
            'title' => 'DataThon Analytics 2025',
            'description' => 'Competencia de análisis de datos y machine learning. Resuelve problemas del mundo real usando ciencia de datos.',
            'start_date' => now()->addMonths(2),
            'end_date' => now()->addMonths(2)->addDays(1),
            'location' => 'Laboratorio de Computación',
            'duration_hours' => 24,
            'max_teams' => 10,
            'max_team_members' => 4,
            'type' => 'Análisis de Datos',
            'status' => 'draft',
            'prizes' => [
                '$8,000 MXN',
                '$4,000 MXN',
            ],
            'requirements' => [
                'Conocimientos de Python',
                'Experiencia con bibliotecas de ML',
                'Laptop con GPU (recomendado)',
            ],
            'schedule' => [
                [
                    'name' => 'Registro',
                    'date' => '1 - 20 Abr'
                ],
                [
                    'name' => 'Competencia',
                    'date' => '22 - 23 Abr'
                ],
                [
                    'name' => 'Premiación',
                    'date' => '25 Abr'
                ],
            ],
            'created_by' => $admin->id,
        ]);

        Event::create([
            'title' => 'GameJam 2025',
            'description' => 'Crea un videojuego completo en 48 horas. Trabaja en equipo para diseñar, programar y publicar tu juego.',
            'start_date' => now()->addMonths(3),
            'end_date' => now()->addMonths(3)->addDays(2),
            'location' => 'Centro de Innovación Digital',
            'duration_hours' => 48,
            'max_teams' => 15,
            'max_team_members' => 5,
            'type' => 'Desarrollo de Juegos',
            'status' => 'draft',
            'prizes' => [
                '$15,000 MXN',
                '$8,000 MXN',
                '$4,000 MXN',
            ],
            'requirements' => [
                'Motor de juego instalado (Unity, Unreal, Godot)',
                'Equipo multidisciplinario',
                'Portfolio de proyectos (opcional)',
            ],
            'schedule' => [
                [
                    'name' => 'Registro',
                    'date' => '1 - 25 May'
                ],
                [
                    'name' => 'GameJam',
                    'date' => '27 - 29 May'
                ],
                [
                    'name' => 'Evaluación',
                    'date' => '30 May'
                ],
                [
                    'name' => 'Premiación',
                    'date' => '1 Jun'
                ],
            ],
            'created_by' => $admin->id,
        ]);

        $this->command->info('✅ Eventos y equipos de prueba creados exitosamente');
        $this->command->info('📧 Email admin: admin@ejemplo.com | Password: password');
        $this->command->info('📧 Email usuarios: juan.perez@ejemplo.com, maria.garcia@ejemplo.com, etc. | Password: password');
    }
}