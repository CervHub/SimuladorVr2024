<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\Company::create([
            'name' => 'Cerv',
            'description' => 'Empresa de Realidad Virtual',
            'ruc' => '20203957462',
            'status' => '1',
        ]);

        \App\Models\User::create([
            'name' => 'Elfer',
            'last_name' => 'Arenas',
            'doi' => '70605040',
            'email' => 'cerv@cerv.com',
            'password' => bcrypt('123456'), // Utiliza bcrypt() para generar un hash
            'password_text' => '123456', 
            'status' => '1',
        ]);

        \App\Models\Service::create([
            'name' => 'Cerv',
            'description' => 'Empresa de Realidad Virtual',
            'ruc' => '20203957462',
            'status' => '1',
            'id_company' => '1'
        ]);
        
        \App\Models\Role::create([
            'name' => 'Superadmin',
            'description' => 'Rol Super Administrador',
            'status' => '1',
        ]);
        
        \App\Models\Role::create([
            'name' => 'Administrador',
            'description' => 'Rol Administrador',
            'status' => '1',
        ]);
        
        \App\Models\Role::create([
            'name' => 'Entrenador',
            'description' => 'Rol Entrenador',
            'status' => '1',
        ]);
        
        \App\Models\Role::create([
            'name' => 'Trabajador',
            'description' => 'Rol Trabajador',
            'status' => '1',
        ]);
        
        \App\Models\Worker::create([
            'code_worker' => '100-001-70605040',
            'id_role' => '1',
            'id_user' => '1',
            'id_company' => '1',
            'id_service' => '1',
            'position' => 'Administrador de Proyectos',
            'status' => '1',
        ]);
    }
}
