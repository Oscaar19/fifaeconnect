<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $managerRole = Role::create(['name' => 'manager']);
        $jugadorRole = Role::create(['name' => 'jugador']);
        $coachRole = Role::create(['name' => 'coach']);
        $usuariRole = Role::create(['name' => 'usuari']);
  

        Permission::create(['name' => 'users.list']);
        Permission::create(['name' => 'users.delete']);

        $adminRole->givePermissionTo(['users.list','users.delete']);

        $name  = config('admin.name');
        $admin = User::where('nom', $name)->first();
        $admin->assignRole('admin');
    }
}
