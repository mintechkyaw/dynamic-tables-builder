<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = $request->per_page == -1
            ? User::where('id', '!=', auth()->id())->get()
            : User::where('id', '!=', auth()->id())->when($request->search, function ($query) use ($request) {
                $query->whereAny(['name', 'email'], 'like', "%$request->search%");
            })->paginate($request->per_page);

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        $user = User::create($data);
        $user->permissions()->attach($data['permissions']);

        return response()->json([
            'message' => 'User Created Successfully!',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();
        $user->update($data);
        if (! empty($data['permissions'])) {
            $user->permissions()->attach($data['permissions']);
        }

        return response()->json([
            'message' => 'User Information Updated Successfully!',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'message' => 'User Deleted!',
        ]);
    }
}
