<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'superAdmin',
            'email' => 'superadmin@gmail.com',
            'role_id' => Role::where('name', 'superAdmin')->first()->id,
            'password' => Hash::make('superadmin1234'),
        ])->permissions()->attach(Permission::where(['name' => 'manage-all'])->pluck('id'));

        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role_id' => Role::where('name', 'admin')->first()->id,
            'password' => Hash::make('admin1234'),
        ])->permissions()->attach(Permission::whereIn('name', ['create-form', 'read-form', 'update-form', 'delete-form', 'create-user', 'read-user', 'update-user', 'delete-user'])->pluck('id'));

        User::create([
            'name' => 'Manager',
            'email' => 'manager@gmail.com',
            'role_id' => Role::where('name', 'manager')->first()->id,
            'password' => Hash::make('manager1234'),
        ])->permissions()->attach(Permission::whereIn('name', ['create-form', 'read-form', 'update-form', 'delete-form'])->pluck('id'));

        User::create([
            'name' => 'Editor',
            'email' => 'editor@gmail.com',
            'role_id' => Role::where('name', 'editor')->first()->id,
            'password' => Hash::make('editor1234'),
        ])->permissions()->attach(Permission::whereIn('name', ['read-form', 'update-form'])->pluck('id'));


    }
}
