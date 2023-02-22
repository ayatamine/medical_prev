<?php
namespace App\Policies;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdPolicy
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
        return $user->hasPermissionTo('ads.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param    \App\Models\User  $user
     * @param    Ad  $ad
     * @return  mixed
     */
    public function view(User $user, Ad $ad)
    {
        return $user->hasPermissionTo('ads.show');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param    \App\Models\User  $user
     * @return  mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('ads.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param    \App\Models\User  $user
     * @param    Ad  $ad
     * @return  mixed
     */
    public function update(User $user, Ad $ad)
    {
        return $user->hasPermissionTo('ads.edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param    \App\Models\User  $user
     * @param    Ad  $ad
     * @return  mixed
     */
    public function delete(User $user, Ad $ad)
    {
        return $user->hasPermissionTo('ads.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param    \App\Models\User  $user
     * @param    Ad  $ad
     * @return  mixed
     */
    public function restore(User $user, Ad $ad)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param    \App\Models\User  $user
     * @param    Ad  $ad
     * @return  mixed
     */
    public function forceDelete(User $user, Ad $ad)
    {
        return $user->hasPermissionTo('ads.delete');
    }
}
