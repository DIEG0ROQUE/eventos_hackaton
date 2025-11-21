<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Perfil;
use App\Models\Carrera;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener roles y carreras
        $rolEstudiante = Role::where('name', 'estudiante')->first();
        $rolAdmin = Role::where('name', 'admin')->first();
        $rolJuez = Role::where('name', 'juez')->first();
        
        $carreraISC = Carrera::where('clave', 'ISC')->first();
        $carreraIGE = Carrera::where('clave', 'IGE')->first();

        // 1. Usuario Administrador
        $admin = User::firstOrCreate(
            ['email' => 'admin@itoaxaca.edu.mx'],
            [
                'name' => 'Administrador del Sistema',
                'password' => Hash::make('password'),
            ]
        );
        $admin->roles()->sync([$rolAdmin->id]);
        
        Perfil::firstOrCreate(
            ['user_id' => $admin->id],
            [
                'telefono' => '9511234567',
                'biografia' => 'Administrador del sistema de eventos académicos',
            ]
        );

        // 2. Usuario Juez
        $juez = User::firstOrCreate(
            ['email' => 'juez@itoaxaca.edu.mx'],
            [
                'name' => 'Dr. David Almaraz',
                'password' => Hash::make('password'),
            ]
        );
        $juez->roles()->sync([$rolJuez->id]);
        
        Perfil::firstOrCreate(
            ['user_id' => $juez->id],
            [
                'telefono' => '9511234568',
                'biografia' => 'Profesor investigador especializado en desarrollo de software',
            ]
        );

        // 3. Estudiante 1 (De tu diseño - Angel)
        $estudiante1 = User::firstOrCreate(
            ['email' => 'angel@itoaxaca.edu.mx'],
            [
                'name' => 'Angel Zarate Matus',
                'password' => Hash::make('password'),
            ]
        );
        $estudiante1->roles()->sync([$rolEstudiante->id]);
        
        Perfil::firstOrCreate(
            ['user_id' => $estudiante1->id],
            [
                'carrera_id' => $carreraISC->id,
                'num_control' => '22161154',
                'telefono' => '9511234569',
                'semestre' => 7,
                'biografia' => 'Estudiante apasionado por el desarrollo web y la inteligencia artificial',
                'github_url' => 'https://github.com/angelzarate',
                'linkedin_url' => 'https://linkedin.com/in/angelzarate',
            ]
        );

        // 4. Estudiante 2 (De tu diseño - Karla)
        $estudiante2 = User::firstOrCreate(
            ['email' => 'karla@itoaxaca.edu.mx'],
            [
                'name' => 'Karla Rocío Delgado Molina',
                'password' => Hash::make('password'),
            ]
        );
        $estudiante2->roles()->sync([$rolEstudiante->id]);
        
        Perfil::firstOrCreate(
            ['user_id' => $estudiante2->id],
            [
                'carrera_id' => $carreraISC->id,
                'num_control' => '22161155',
                'telefono' => '9511234570',
                'semestre' => 7,
                'biografia' => 'Diseñadora UI/UX enfocada en crear experiencias digitales',
            ]
        );

        // 5. Estudiante 3 (De tu diseño - Jesús)
        $estudiante3 = User::firstOrCreate(
            ['email' => 'jesus@itoaxaca.edu.mx'],
            [
                'name' => 'Jesús Martínez Martínez',
                'password' => Hash::make('password'),
            ]
        );
        $estudiante3->roles()->sync([$rolEstudiante->id]);
        
        Perfil::firstOrCreate(
            ['user_id' => $estudiante3->id],
            [
                'carrera_id' => $carreraIGE->id,
                'num_control' => '22161156',
                'telefono' => '9511234571',
                'semestre' => 6,
                'biografia' => 'Analista de negocios con interés en startups tecnológicas',
            ]
        );

        // 6. Estudiante 4
        $estudiante4 = User::firstOrCreate(
            ['email' => 'maria@itoaxaca.edu.mx'],
            [
                'name' => 'María López García',
                'password' => Hash::make('password'),
            ]
        );
        $estudiante4->roles()->sync([$rolEstudiante->id]);
        
        Perfil::firstOrCreate(
            ['user_id' => $estudiante4->id],
            [
                'carrera_id' => $carreraISC->id,
                'num_control' => '22161157',
                'telefono' => '9511234572',
                'semestre' => 5,
                'biografia' => 'Especialista en ciencia de datos y machine learning',
            ]
        );

        $this->command->info('✅ Usuarios de prueba creados:');
        $this->command->info('   Admin: admin@itoaxaca.edu.mx / password');
        $this->command->info('   Juez: juez@itoaxaca.edu.mx / password');
        $this->command->info('   Estudiante 1: angel@itoaxaca.edu.mx / password');
        $this->command->info('   Estudiante 2: karla@itoaxaca.edu.mx / password');
        $this->command->info('   Estudiante 3: jesus@itoaxaca.edu.mx / password');
        $this->command->info('   Estudiante 4: maria@itoaxaca.edu.mx / password');
    }
}