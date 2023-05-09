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
        $moderadorRole = Role::create(['name' => 'moderador']);

        Permission::create(['name' => 'users.list']);
        Permission::create(['name' => 'users.delete']);

        $moderadorRole->givePermissionTo(['users.list','users.delete']);

        $name  = config('admin.name');
        $admin = User::where('nom', $name)->first();
        $admin->assignRole('moderador');
    }
}
