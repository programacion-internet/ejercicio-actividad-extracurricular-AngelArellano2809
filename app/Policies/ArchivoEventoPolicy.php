<?php

namespace App\Policies;

use App\Models\ArchivoEvento;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArchivoEventoPolicy
{
    public function upload(User $user, Evento $evento)
    {
        // Solo alumnos inscritos pueden subir
        return !$user->is_admin && $evento->users()->where('user_id', $user->id)->exists();
    }
    
    public function view(User $user, ArchivoEvento $archivo)
    {
        // Admin puede ver todo, usuarios solo ven sus archivos
        return $user->is_admin || $archivo->user_id === $user->id;
    }

    public function delete(User $user, ArchivoEvento $archivo)
    {
        // Solo el dueño puede eliminar
        return $archivo->user_id === $user->id;
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
    public function update(User $user, ArchivoEvento $archivo): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ArchivoEvento $archivo): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ArchivoEvento $archivo): bool
    {
        return false;
    }
}
