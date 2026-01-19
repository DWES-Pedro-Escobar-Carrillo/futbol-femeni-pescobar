<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'message' => 'Usuari registrat correctament',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Credencials incorrectes'], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'message' => 'Login correcte',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        // Revoca el token actual
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout correcte']);
    }

    public function me(Request $request)
    {
        // Retorna l'usuari i els seus permisos (si tens rols implementats, afegeix-los aquí)
        return response()->json([
            'user' => $request->user(),
            // 'roles' => $request->user()->roles, // Descomentar si tens relació de rols
        ]);
    }
}