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
        $adminRole = Role::create([
            'name' => 'superadmin',
            'guard_name' => 'web'
        ]);
        Role::create([
            'name' => 'localadmin',
            'guard_name' => 'web'
        ]);
        $permissions = [
            'dashboard',
            'users.index',
            'users.create',
            'users.approve',
            'users.unapprove',
            'users.edit',
            'users.block',
            'users.unblock',
            'place.index',
            'place.edit',
            'place.delete',
            'place.print',
            'event.index',
            'event.create',
            'event.edit',
            'event.delete',
            'profile.index'
        ];

        foreach($permissions as $permission){
            Permission::create([
                'name' => $permission
            ]);
        }

        $admin = User::create([
            'name' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'address' => 'Jl Denpasar',
            'phone' => '08123456789',
            'password' => Hash::make('superadmin'),
            'approved_at' => Carbon::now()
        ]);

        $admin->assignRole('superadmin');

        foreach($permissions as $permission){
            $adminRole->givePermissionTo($permission);
        }

        $local = User::create([
            'name' => 'localadmin',
            'email' => 'local@gmail.com',
            'address' => 'Jl Denpasar',
            'phone' => '08123456789',
            'password' => Hash::make('local'),
            'approved_at' => Carbon::now()
        ]);

        $local->assignRole('localadmin');
    }
}
