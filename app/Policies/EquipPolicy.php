<?php

namespace App\Policies;

use App\Models\Equip;
use App\Models\User;

class EquipPolicy
{
    public function create(User $user): bool
    {
        // Solo admin puede crear
        return $user->role === 'admin' || $user->role === 'administrador';
    }

    public function update(User $user, Equip $equip): bool
    {
        // Admin o el Manager PROPIETARIO del equipo
        return $user->role === 'admin' || 
               $user->role === 'administrador' || 
               ($user->role === 'manager' && $user->team_id === $equip->id);
    }

    public function delete(User $user, Equip $equip): bool
    {
        // Solo admin puede borrar
        return $user->role === 'admin' || $user->role === 'administrador';
    }
}