<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
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
        \App\Models\Form::factory()
            ->has(\App\Models\FormField::factory()->count(10), 'fields')
            ->count(3)
            ->create();
        $role = Role::create([
            'name' => 'superAdmin',
        ]);
        $predefinedPermissions = ['manage-all', 'create-form', 'read-form', 'update-form', 'delete-form', 'create-user', 'read-user', 'update-user', 'delete-user'];
        foreach ($predefinedPermissions as $p) {
            Permission::create(['name' => $p]);
        }
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role_id' => $role->id,
            'password' => Hash::make('admin1234'),
        ]);
        $user->permissions()->attach(Permission::where(['name' => 'manage-all'])->pluck('id'));
    }
}
