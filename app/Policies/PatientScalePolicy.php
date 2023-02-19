<?php
namespace App\Policies;

use App\Models\PatientScale;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PatientScalePolicy
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
        return $user->hasPermissionTo('patient-scales.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param    \App\Models\User  $user
     * @param    PatientScale  $patientScale
     * @return  mixed
     */
    public function view(User $user, PatientScale $patientScale)
    {
        return $user->hasPermissionTo('patient-scales.show');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param    \App\Models\User  $user
     * @return  mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('patient-scales.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param    \App\Models\User  $user
     * @param    PatientScale  $patientScale
     * @return  mixed
     */
    public function update(User $user, PatientScale $patientScale)
    {
        return $user->hasPermissionTo('patient-scales.edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param    \App\Models\User  $user
     * @param    PatientScale  $patientScale
     * @return  mixed
     */
    public function delete(User $user, PatientScale $patientScale)
    {
        return $user->hasPermissionTo('patient-scales.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param    \App\Models\User  $user
     * @param    PatientScale  $patientScale
     * @return  mixed
     */
    public function restore(User $user, PatientScale $patientScale)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param    \App\Models\User  $user
     * @param    PatientScale  $patientScale
     * @return  mixed
     */
    public function forceDelete(User $user, PatientScale $patientScale)
    {
        return $user->hasPermissionTo('patient-scales.delete');
    }
}
