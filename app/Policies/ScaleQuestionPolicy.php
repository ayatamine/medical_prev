<?php
namespace App\Policies;

use App\Models\ScaleQuestion;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ScaleQuestionPolicy
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
        return $user->hasPermissionTo('scale-questions.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param    \App\Models\User  $user
     * @param    ScaleQuestion  $scaleQuestion
     * @return  mixed
     */
    public function view(User $user, ScaleQuestion $scaleQuestion)
    {
        return $user->hasPermissionTo('scale-questions.show');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param    \App\Models\User  $user
     * @return  mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('scale-questions.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param    \App\Models\User  $user
     * @param    ScaleQuestion  $scaleQuestion
     * @return  mixed
     */
    public function update(User $user, ScaleQuestion $scaleQuestion)
    {
        return $user->hasPermissionTo('scale-questions.edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param    \App\Models\User  $user
     * @param    ScaleQuestion  $scaleQuestion
     * @return  mixed
     */
    public function delete(User $user, ScaleQuestion $scaleQuestion)
    {
        return $user->hasPermissionTo('scale-questions.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param    \App\Models\User  $user
     * @param    ScaleQuestion  $scaleQuestion
     * @return  mixed
     */
    public function restore(User $user, ScaleQuestion $scaleQuestion)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param    \App\Models\User  $user
     * @param    ScaleQuestion  $scaleQuestion
     * @return  mixed
     */
    public function forceDelete(User $user, ScaleQuestion $scaleQuestion)
    {
        return $user->hasPermissionTo('scale-questions.delete');
    }
}
