<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Permission::factory(10)->create();
        // Permission::create([
        //     'name' => 'manage-all',
        // ]);

        // \App\Models\Form::factory()
        //     ->has(\App\Models\FormField::factory()->count(10), 'fields')
        //     ->count(5)
        //     ->create();
        // User::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@gmail.com',
        //     'role_id' => 11,
        //     'password' => Hash::make('admin1234'),
        // ]);
    }
}
