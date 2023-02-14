<?php
namespace App\Policies;

use App\Models\ChronicDisease;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChronicDiseasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param    \App\Models\User  $user
     * @return  mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('chronic-diseases.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param    \App\Models\User  $user
     * @param    ChronicDisease  $chronicDisease
     * @return  mixed
     */
    public function view(User $user, ChronicDisease $chronicDisease)
    {
        return $user->hasPermissionTo('chronic-diseases.show');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param    \App\Models\User  $user
     * @return  mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('chronic-diseases.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param    \App\Models\User  $user
     * @param    ChronicDisease  $chronicDisease
     * @return  mixed
     */
    public function update(User $user, ChronicDisease $chronicDisease)
    {
        return $user->hasPermissionTo('chronic-diseases.edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param    \App\Models\User  $user
     * @param    ChronicDisease  $chronicDisease
     * @return  mixed
     */
    public function delete(User $user, ChronicDisease $chronicDisease)
    {
        return $user->hasPermissionTo('chronic-diseases.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param    \App\Models\User  $user
     * @param    ChronicDisease  $chronicDisease
     * @return  mixed
     */
    public function restore(User $user, ChronicDisease $chronicDisease)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param    \App\Models\User  $user
     * @param    ChronicDisease  $chronicDisease
     * @return  mixed
     */
    public function forceDelete(User $user, ChronicDisease $chronicDisease)
    {
        return $user->hasPermissionTo('chronic-diseases.delete');
    }
}
