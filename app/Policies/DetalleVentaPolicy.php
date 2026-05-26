<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use App\Models\DetalleVenta;

class DetalleVentaPolicy
{
    /**
     * Filtro previo global (Super Admin / Usuarios sin rol)
     */
    public function before(User $user, string $ability)
    {
        // 1. Si el usuario no tiene ningún rol asignado, bloquear el acceso por completo
        if ($user->roles()->count() === 0) {
            return false;
        }

        // 2. Si es super_admin o admin, hereda todos los permisos automáticamente
        if ($user->hasRole(['super_admin', 'admin', 'Admin'])) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models (Menu lateral).
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_detalle::venta');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DetalleVenta $detalleVenta): bool
    {
        return $user->can('view_detalle::venta');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_detalle::venta');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DetalleVenta $detalleVenta): bool
    {
        return $user->can('update_detalle::venta');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DetalleVenta $detalleVenta): bool
    {
        return $user->can('delete_detalle::venta');
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_detalle::venta');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DetalleVenta $detalleVenta): bool
    {
        return $user->can('restore_detalle::venta');
    }

    /**
     * Determine whether the user can restore any models.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_detalle::venta');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DetalleVenta $detalleVenta): bool
    {
        return $user->can('force_delete_detalle::venta');
    }

    /**
     * Determine whether the user can permanently delete any models.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_detalle::venta');
    }

    /**
     * Determine whether the user can replicate the model.
     */
    public function replicate(User $user, DetalleVenta $detalleVenta): bool
    {
        return $user->can('replicate_detalle::venta');
    }

    /**
     * Determine whether the user can reorder models.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_detalle::venta');
    }
}
