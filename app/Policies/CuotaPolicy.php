<?php

namespace App\Policies;

use App\Models\Cuota;
use App\Models\User as AuthUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class CuotaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Cuota');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(AuthUser $authUser, Cuota $cuota): bool
    {
       return $authUser->can('View:Cuota');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Cuota');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(AuthUser $authUser, Cuota $cuota): bool
    {
        return $authUser->can('Update:Cuota');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(AuthUser $authUser, Cuota $cuota): bool
    {
        return $authUser->can('Delete:Cuota');
    }

  public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Cuota');
    }

    public function restore(AuthUser $authUser, Cuota $cuota): bool
    {
        return $authUser->can('Restore:Cuota');
    }

    public function forceDelete(AuthUser $authUser, Cuota $cuota): bool
    {
        return $authUser->can('ForceDelete:Cuota');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Cuota');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Cuota');
    }

    public function replicate(AuthUser $authUser, Cuota $cuota): bool
    {
        return $authUser->can('Replicate:Cuota');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Cuota');
    }
 //ya sabes papy
}
