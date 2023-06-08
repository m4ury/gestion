<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /* \App\Models\Department::factory(6)->create();
        \App\Models\Employee::factory(25)->create(); */

        \App\Models\User::factory()->create([
            'rut' => '16808624-5',
            'name' => 'Mauricio',
            'apellidoP' => 'Morales',
            'email' => 'mmoraless@ssmaule.cl',
            'password' => Hash::make('maxy2001'),
            'type' => 'admin'
        ]);
    }
}
