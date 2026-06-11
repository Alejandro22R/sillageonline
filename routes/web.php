<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Store\Catalog;
use App\Livewire\Admin\Giveaway;

Route::get('/', Catalog::class);

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/admin/sorteo-secreto', Giveaway::class)
    ->middleware(['auth'])
    ->name('admin.giveaway');

require __DIR__.'/auth.php';
