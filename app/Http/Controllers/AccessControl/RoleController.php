<?php

namespace App\Http\Controllers\AccessControl;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['data' => Role::get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        Role::create($data);

        return response()->json([
            'message' => 'Role Created Successfully!',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'data' => $role,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        $role->update($data);

        return response()->json([
            'message' => 'Role Name Updated!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json([
            'message' => 'Role  Deleted!',
        ]);
    }
}
