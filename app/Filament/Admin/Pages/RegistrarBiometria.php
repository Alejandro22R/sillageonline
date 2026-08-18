<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;

class RegistrarBiometria extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-finger-print';
    protected static string | \UnitEnum | null $navigationGroup = 'Administración';
    protected static ?int $navigationSort = 20;
    protected static ?string $navigationLabel = 'Seguridad Biométrica';
    protected static ?string $title = 'Registrar Huella Dactilar';

    protected string $view = 'filament.admin.pages.registrar-biometria';
}