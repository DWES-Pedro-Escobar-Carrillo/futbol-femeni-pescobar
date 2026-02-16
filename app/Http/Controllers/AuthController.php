<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    // Redirigeix a Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Gestiona la resposta de Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Error autenticant amb Google.');
        }

        // Busquem si l'usuari ja existeix pel correu
        $user = User::where('email', $googleUser->email)->first();

        if ($user) {
            // RESTRICCIÓ: Si l'usuari existeix però NO és 'convidat' (és admin o manager),
            // no li permetem entrar amb Google per seguretat/política.
            if ($user->role !== 'convidat') {
                return redirect()->route('login')
                    ->withErrors(['email' => 'Els usuaris Administradors i Mànagers han d\'entrar amb contrasenya, no amb Google.']);
            }

            // Si és convidat, actualitzem avatar i Google ID si cal
            $user->update([
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
            ]);
        } else {
            // Si no existeix, el creem com a CONVIDAT
            // Generem un password aleatori perquè la BD no es queixi, 
            // però l'usuari no el sabrà (només pot entrar amb Google).
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
                'role' => 'convidat', // Rol per defecte per a usuaris de Google
                'password' => Hash::make(Str::random(32)), // Password segur i desconegut
            ]);
        }

        // Fem login de l'usuari
        Auth::login($user);

        return redirect()->intended('dashboard');
    }
}