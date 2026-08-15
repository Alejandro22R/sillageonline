<?php

namespace App\Filament\Admin\Resources\Notes\Pages;

use App\Filament\Admin\Resources\Notes\NoteResource;
use Filament\Resources\Pages\CreateRecord;

class CreateNote extends CreateRecord
{
    protected static string $resource = NoteResource::class;
}
