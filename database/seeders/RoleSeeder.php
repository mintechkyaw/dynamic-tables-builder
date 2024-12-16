<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $predefinedRoles = ['superAdmin', 'admin', 'manager', 'editor', 'normal'];
        foreach ($predefinedRoles as $r) {
            Role::create(['name' => $r]);
        }
    }
}
