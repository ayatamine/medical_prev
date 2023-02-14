<?php
namespace App\Policies;

use App\Models\Allergy;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AllergyPolicy
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
        return $user->hasPermissionTo('allergies.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param    \App\Models\User  $user
     * @param    Allergy  $allergy
     * @return  mixed
     */
    public function view(User $user, Allergy $allergy)
    {
        return $user->hasPermissionTo('allergies.show');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param    \App\Models\User  $user
     * @return  mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('allergies.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param    \App\Models\User  $user
     * @param    Allergy  $allergy
     * @return  mixed
     */
    public function update(User $user, Allergy $allergy)
    {
        return $user->hasPermissionTo('allergies.edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param    \App\Models\User  $user
     * @param    Allergy  $allergy
     * @return  mixed
     */
    public function delete(User $user, Allergy $allergy)
    {
        return $user->hasPermissionTo('allergies.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param    \App\Models\User  $user
     * @param    Allergy  $allergy
     * @return  mixed
     */
    public function restore(User $user, Allergy $allergy)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param    \App\Models\User  $user
     * @param    Allergy  $allergy
     * @return  mixed
     */
    public function forceDelete(User $user, Allergy $allergy)
    {
        return $user->hasPermissionTo('allergies.delete');
    }
}
