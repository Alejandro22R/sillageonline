<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Cuota;
use Illuminate\Auth\Access\HandlesAuthorization;

class CuotaPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Cuota');
    }

    public function view(AuthUser $authUser, Cuota $cuota): bool
    {
        return $authUser->can('View:Cuota');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Cuota');
    }

    public function update(AuthUser $authUser, Cuota $cuota): bool
    {
        return $authUser->can('Update:Cuota');
    }

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

}