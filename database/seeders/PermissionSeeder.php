<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $predefinedPermissions = [
            'manage-all',
            'create-form',
            'read-form',
            'update-form',
            'delete-form',
            'create-user',
            'read-user',
            'update-user',
            'delete-user'];

        foreach ($predefinedPermissions as $p) {
            Permission::create(['name' => $p]);
        }
    }
}
