<?php

namespace App\Policies;

use App\Models\MaterialApoio;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaterialApoioPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->nivel === User::NIVEL_PROFESSOR && $user->professor()->exists();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MaterialApoio  $materialApoio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, MaterialApoio $materialApoio)
    {
        return $user->professor && $materialApoio->professor_id === $user->professor->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->nivel === User::NIVEL_PROFESSOR && $user->professor()->exists();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MaterialApoio  $materialApoio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, MaterialApoio $materialApoio)
    {
        return $user->professor && $materialApoio->professor_id === $user->professor->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MaterialApoio  $materialApoio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, MaterialApoio $materialApoio)
    {
        return $user->professor && $materialApoio->professor_id === $user->professor->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MaterialApoio  $materialApoio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, MaterialApoio $materialApoio)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MaterialApoio  $materialApoio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, MaterialApoio $materialApoio)
    {
        //
    }
}
