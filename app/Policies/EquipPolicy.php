<?php

namespace App\Policies;

use App\Models\Equip;
use App\Models\User;

class EquipPolicy
{
    public function viewAny(User $user): bool { return true; }
    public function view(User $user, Equip $equip): bool { return true; }

    public function create(User $user): bool
    {
        // Admin, o Manager que encara no té equip assignat
        return $user->role === 'admin' || ($user->role === 'manager' && $user->team_id === null);
    }

    public function update(User $user, Equip $equip): bool
    {
        // Admin, o Manager propietari d'aquest equip
        return $user->role === 'admin' || 
               ($user->role === 'manager' && $user->team_id === $equip->id);
    }

    public function delete(User $user, Equip $equip): bool
    {
        return $user->role === 'admin' || 
               ($user->role === 'manager' && $user->team_id === $equip->id);
    }
}