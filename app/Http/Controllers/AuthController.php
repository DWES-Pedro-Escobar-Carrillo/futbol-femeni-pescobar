<?php
namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /*public function redirectToGoogle()
{
    return Socialite::driver('google')
        ->with(['prompt' => 'select_account']) // Esto fuerza la selección de cuenta
        ->redirect();
}*/

    public function handleGoogleCallback()
{
    $googleUser = Socialite::driver('google')->stateless()->user();

    // Busca por email, y SIEMPRE actualiza o crea los campos del segundo array
    $user = User::updateOrCreate(
        ['email' => $googleUser->getEmail()], // Búsqueda
        [
            'name' => $googleUser->getName(),
            'google_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
            // El password solo se asigna si es un usuario nuevo
            'password' => bcrypt(str()->random(24)), 
        ]
    );

    Auth::login($user);

    return redirect('/dashboard');
}
}