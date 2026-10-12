<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Store\Catalog;
use App\Livewire\Admin\Giveaway;
use App\Livewire\Store\ProductDetail;

Route::get('/store/{slug}', ProductDetail::class)->name('store.product');

Route::get('/', Catalog::class);

Route::passkeys();

// Redirige /dashboard al panel de Filament manteniendo el nombre de ruta
// para que el login de Breeze no falle al buscar route('dashboard')
Route::redirect('/dashboard', '/admin')->name('dashboard');

Route::get('/admin/sorteo-secreto', Giveaway::class)
    ->middleware(['auth'])
    ->name('admin.giveaway');

require __DIR__.'/auth.php';
