<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function show()
    {
        return response()->json([
            'fields' => ['name', 'email', 'password'],
            'message' => 'Please fill out the fields to register.',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:60',
            'email' => 'required|email|unique:users',
            'address' => 'required|string|max:60',
            'phone' => 'required|string',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
        ]);

        // $token= Auth::login($user);

        return response()->json([
            'message ' => 'succes registration',
            // 'token' => $token
        ], 201);
    }
}
