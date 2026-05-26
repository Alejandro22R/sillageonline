<?php

namespace App\Filament\Admin\Resources\Products\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('marca_perfume')
                    ->placeholder('-'),
                TextEntry::make('stock')
                    ->numeric(),
                TextEntry::make('wholesale_price')
                    ->money()
                    ->placeholder('-'),
                TextEntry::make('retail_price')
                    ->money(),
                TextEntry::make('metodo_pago')
                    ->placeholder('-'),
                TextEntry::make('precio_divisa')
                    ->money()
                    ->placeholder('-'),
                IconEntry::make('is_exclusive')
                    ->boolean(),
                IconEntry::make('is_offer')
                    ->boolean(),
                TextEntry::make('offer_price')
                    ->money()
                    ->placeholder('-'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                ImageEntry::make('image')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
