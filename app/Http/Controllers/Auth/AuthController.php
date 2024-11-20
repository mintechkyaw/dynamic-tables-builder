<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register()
    {
        $validator = Validator::make(request()->all(), [
            'name' => ['required', 'min:4', 'max:40'],
            'email' => ['required', 'email', 'email:rfc,dns', 'unique:users,email'],
            'password' => ['required', 'min:6', 'max:30'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Unprocessable Content',
                'errors' => $validator->errors(),
            ], 422);
        }
        User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
        ]);

        return response()->json([
            'message' => 'User account successfully created. Please Login',
        ]);
    }

    public function login()
    {
        $validator = Validator::make(request()->all(), [
            'email' => ['required', 'email', 'email:rfc,dns'],
            'password' => ['required', 'min:6', 'max:30'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Unprocessable Content',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', request('email'))->first();

        if (! $user) {
            return response()->json([
                'message' => "Email doesn't exists.",
            ], 422);
        }

        $isPasswordCorrect = Hash::check(request('password'), $user->password);

        if (! $isPasswordCorrect) {
            return response()->json([
                'message' => 'Password Incorrect.',
            ], 422);
        }

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'message' => 'Login Success.',
            'token' => $token,
            'user' => $user,
        ], 200);
    }
}
