<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Permission;

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
            'approved_at' => Carbon::now(),
            'email_verified_at' => Carbon::now(),
        ]);

        $admin->assignRole('superadmin');

        $local = User::create([
            'name' => 'localadmin',
            'email' => 'local@gmail.com',
            'address' => 'Jl Denpasar',
            'phone' => '08123456789',
            'password' => Hash::make('local'),
            'approved_at' => Carbon::now(),
            'email_verified_at' => Carbon::now(),
        ]);

        $local->assignRole('localadmin');
    }
}
