<?php
namespace App\Policies;

use App\Models\Scale;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ScalePolicy
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
        return $user->hasPermissionTo('scales.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param    \App\Models\User  $user
     * @param    Scale  $scale
     * @return  mixed
     */
    public function view(User $user, Scale $scale)
    {
        return $user->hasPermissionTo('scales.show');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param    \App\Models\User  $user
     * @return  mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('scales.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param    \App\Models\User  $user
     * @param    Scale  $scale
     * @return  mixed
     */
    public function update(User $user, Scale $scale)
    {
        return $user->hasPermissionTo('scales.edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param    \App\Models\User  $user
     * @param    Scale  $scale
     * @return  mixed
     */
    public function delete(User $user, Scale $scale)
    {
        return $user->hasPermissionTo('scales.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param    \App\Models\User  $user
     * @param    Scale  $scale
     * @return  mixed
     */
    public function restore(User $user, Scale $scale)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param    \App\Models\User  $user
     * @param    Scale  $scale
     * @return  mixed
     */
    public function forceDelete(User $user, Scale $scale)
    {
        return $user->hasPermissionTo('scales.delete');
    }
}
