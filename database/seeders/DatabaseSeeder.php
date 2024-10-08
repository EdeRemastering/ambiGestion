<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Roles;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $roles = ['aprendiz', 'instructor', 'admin']; // Incluimos admin, aunque no se use en el registro
        foreach ($roles as $role) {
            Roles::create(['name' => $role]);
        }
    }
}
