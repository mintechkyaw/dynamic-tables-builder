<?php

namespace App\Http\Controllers\AccessControl;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Models\Form;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::get();

        return PermissionResource::collection($permissions);
    }

    public function show(Permission $permission)
    {
        return response()->json([
            'data' => $permission,
        ]);
    }

    public static function generate(Form $form)
    {
        $permissions = ["create-$form->slug", "read-$form->slug", "update-$form->slug", "delete-$form->slug"];
        foreach ($permissions as $p) {
            Permission::create(['name' => $p]);
        }
    }

    public static function deletePermissions(Form $form)
    {
        $permissions = ["create-$form->slug", "read-$form->slug", "update-$form->slug", "delete-$form->slug"];
        foreach ($permissions as $p) {
            $permission = Permission::where('name', $p)->first();
            $permission->delete();
        }
    }
}
