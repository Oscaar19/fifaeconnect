<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles=[
            ['name' => 'moderador'],
            ['name' => 'usuari'],
            ['name' => 'jugador'],
            ['name' => 'coach'],
            ['name' => 'manager'],
            ['name' => 'club'],
        ];
        DB::table('roles')->insert($roles);    
    }
}
