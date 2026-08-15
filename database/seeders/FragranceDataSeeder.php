<?php

namespace Database\Seeders;

use App\Models\Chord;
use App\Models\Note;
use App\Models\Product;
use Illuminate\Database\Seeder;

class FragranceDataSeeder extends Seeder
{
    public function run(): void
    {
        $notes = [
            ['name' => 'Bergamota', 'type' => 'top'],
            ['name' => 'Limón',     'type' => 'top'],
            ['name' => 'Jazmín',    'type' => 'heart'],
            ['name' => 'Rosa',      'type' => 'heart'],
            ['name' => 'Vainilla',  'type' => 'base'],
            ['name' => 'Almizcle',  'type' => 'base'],
        ];

        foreach ($notes as $note) {
            Note::firstOrCreate($note);
        }

        $chords = [
            ['name' => 'Amaderado', 'color' => '#8B5E3C'],
            ['name' => 'Dulce',     'color' => '#C9A227'],
            ['name' => 'Afrutado',  'color' => '#D97757'],
            ['name' => 'Floral',    'color' => '#C77DAD'],
        ];

        foreach ($chords as $chord) {
            Chord::firstOrCreate(['name' => $chord['name']], $chord);
        }

        // Asigna notas y acordes al primer producto que exista, solo para probar
        $product = Product::first();

        if ($product) {
            $product->notes()->sync(Note::pluck('id'));

            $product->chords()->sync([
                Chord::where('name', 'Amaderado')->first()->id => ['intensity' => 80],
                Chord::where('name', 'Dulce')->first()->id     => ['intensity' => 65],
                Chord::where('name', 'Afrutado')->first()->id  => ['intensity' => 40],
            ]);
        }
    }
}