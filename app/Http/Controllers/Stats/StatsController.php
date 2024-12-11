<?php

namespace App\Http\Controllers\Stats;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

class StatsController extends Controller
{
    public function index()
    {
        // $userCount;
        // roles
        // permisions
        // tables
        // forms

        $usersCount = User::count();
        $roleCount = Role::count();
        $permissionsCount = Permission::count();

    }
}
