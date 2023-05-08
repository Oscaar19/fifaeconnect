<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new User([
            'nom'      => config('admin.name'),
            'email'     => config('admin.email'),
            'password'  => Hash::make(config('admin.password')),
        ]);
        $admin->save();
    }
}
