<?php

namespace App\Policies;

use App\Models\Equip;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EquipPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Equip $equip): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function update(User $user, Equip $equip): bool
{
    // L'admin pot editar qualsevol equip
    if ($user->role === 'admin') {
        return true;
    }

    // El manager només pot editar el seu equip assignat
    return $user->role === 'manager' && $user->team_id === $equip->id;
}

// Opcional: viewAny, view, create, delete (soles admin)
public function create(User $user): bool
{
    return $user->role === 'admin';
}

public function delete(User $user, Equip $equip): bool
{
    return $user->role === 'admin';
}

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Equip $equip): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Equip $equip): bool
    {
        return false;
    }
}
