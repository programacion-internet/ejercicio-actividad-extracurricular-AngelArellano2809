<?php

namespace App\Policies;

use App\Models\Evento;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EventoPolicy
{
    public function inscribir(User $user, Evento $evento)
    {
        // Solo alumnos no inscritos pueden inscribirse
        return !$user->is_admin && !$evento->users()->where('user_id', $user->id)->exists();
    }

    public function upload(User $user, Evento $evento)
    {
        // Solo alumnos inscritos pueden subir
        return !$user->is_admin && $evento->users()->where('user_id', $user->id)->exists();
    }
    
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }


    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Evento $evento): bool
    {
        return false;
    }


    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Evento $evento): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Evento $evento): bool
    {
        return false;
    }
}
