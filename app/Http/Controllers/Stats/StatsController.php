<?php

namespace App\Http\Controllers\Stats;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

class StatsController extends Controller
{
    public function index()
    {

        $usersCount = User::count();
        $rolesCount = Role::count();
        $permissionsCount = Permission::count();
        $formsCount = Form::count();
        $tablesCount = Form::where('status', 'published')->count();

        return response()->json([
            'usersCount' => $usersCount,
            'rolesCount' => $rolesCount,
            'permissionsCount' => $permissionsCount,
            'formsCount' => $formsCount,
            'tablesCount' => $tablesCount,
        ]);
    }
}
