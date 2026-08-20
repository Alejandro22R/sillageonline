<?php

namespace App\Observers;

use App\Models\Cuota;

/**
 * Mantiene sincronizado ventas.estado_pago con lo realmente abonado.
 *
 * Cada vez que se guarda o se elimina un abono (Cuota), se recalcula el
 * total pagado de su venta: si ya cubre el total, la venta queda marcada
 * como 'pagado' automáticamente; si no, vuelve a 'pendiente'. Esto no le
 * quita al vendedor la posibilidad de marcarla manualmente como pagada
 * (por ejemplo, si se le perdona un saldo pequeño) — ese ajuste manual solo
 * se recalcula de nuevo si después se registra o borra otro abono.
 */
class CuotaObserver
{
    public function saved(Cuota $cuota): void
    {
        $this->sincronizarVenta($cuota);
    }

    public function deleted(Cuota $cuota): void
    {
        $this->sincronizarVenta($cuota);
    }

    private function sincronizarVenta(Cuota $cuota): void
    {
        $venta = $cuota->venta;

        if (! $venta) {
            return;
        }

        $totalPagado = (float) $venta->cuotas()->sum('monto_cuota');
        $nuevoEstado = $totalPagado >= (float) $venta->total_venta && $totalPagado > 0
            ? 'pagado'
            : 'pendiente';

        if ($venta->estado_pago !== $nuevoEstado) {
            $venta->forceFill(['estado_pago' => $nuevoEstado])->save();
        }
    }
}
