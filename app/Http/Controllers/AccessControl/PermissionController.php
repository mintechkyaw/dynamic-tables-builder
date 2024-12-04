<?php

namespace App\Http\Controllers\AccessControl;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        return response()->json(
            [
                'data' => Permission::get(['id', 'name']),
            ]
        );
    }

    public function show(Permission $permission)
    {
        return response()->json([
            'data' => $permission,
        ]);
    }

    public static function generate(Form $form)
    {
        $permissions = ["$form->slug-create", "$form->slug-read", "$form->slug-update", "$form->slug-delete"];
        foreach ($permissions as $p) {
            Permission::create(['name' => $p]);
        }
    }

    public static function delete(Form $form)
    {
        $permissions = ["$form->slug-create", "$form->slug-read", "$form->slug-update", "$form->slug-delete"];
        foreach ($permissions as $p) {
            $permission = Permission::where('name', $p)->first();
            $permission->delete();
        }
    }
}
