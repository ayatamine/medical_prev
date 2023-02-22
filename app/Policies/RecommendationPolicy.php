<?php
namespace App\Policies;

use App\Models\Recommendation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecommendationPolicy
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
        return $user->hasPermissionTo('recommendations.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param    \App\Models\User  $user
     * @param    Recommendation  $recommendation
     * @return  mixed
     */
    public function view(User $user, Recommendation $recommendation)
    {
        return $user->hasPermissionTo('recommendations.show');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param    \App\Models\User  $user
     * @return  mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('recommendations.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param    \App\Models\User  $user
     * @param    Recommendation  $recommendation
     * @return  mixed
     */
    public function update(User $user, Recommendation $recommendation)
    {
        return $user->hasPermissionTo('recommendations.edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param    \App\Models\User  $user
     * @param    Recommendation  $recommendation
     * @return  mixed
     */
    public function delete(User $user, Recommendation $recommendation)
    {
        return $user->hasPermissionTo('recommendations.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param    \App\Models\User  $user
     * @param    Recommendation  $recommendation
     * @return  mixed
     */
    public function restore(User $user, Recommendation $recommendation)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param    \App\Models\User  $user
     * @param    Recommendation  $recommendation
     * @return  mixed
     */
    public function forceDelete(User $user, Recommendation $recommendation)
    {
        return $user->hasPermissionTo('recommendations.delete');
    }
}
