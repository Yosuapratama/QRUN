<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'superadmin',
            'guard_name' => 'web'
        ]);
        Role::create([
            'name' => 'localadmin',
            'guard_name' => 'web'
        ]);

        $admin = User::create([
            'name' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'address' => 'Jl Denpasar',
            'phone' => '08123456789',
            'password' => Hash::make('superadmin'),
            'is_deleted' => 0,
            'is_approved' => 1
        ]);

        $admin->assignRole('superadmin');

        $local = User::create([
            'name' => 'localadmin',
            'email' => 'local@gmail.com',
            'address' => 'Jl Denpasar',
            'phone' => '08123456789',
            'password' => Hash::make('local'),
            'is_deleted' => 0,
            'is_approved' => 1
        ]);

        $local->assignRole('localadmin');
    }
}
