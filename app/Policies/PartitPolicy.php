<?php

namespace App\Policies;

use App\Models\Partit;
use App\Models\User;

class PartitPolicy
{
    public function viewAny(User $user): bool { return true; }
    public function view(User $user, Partit $partit): bool { return true; }

    public function create(User $user): bool
    {
        // "No es permet crear partits manualment" (llevat potser de l'Admin)
        return $user->role === 'admin';
    }

    public function update(User $user, Partit $partit): bool
    {
        // Admin pot editar tot. 
        // L'àrbitre només si és l'assignat al partit (arbitre_id)
        return $user->role === 'admin' || 
               ($user->role === 'arbitre' && $partit->arbitre_id === $user->id);
    }

    public function delete(User $user, Partit $partit): bool
    {
        return $user->role === 'admin';
    }
}