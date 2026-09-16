<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            'Action', 'Adventure', 'RPG', 'Shooter', 'Strategy',
            'Simulation', 'Sports', 'Racing', 'Fighting', 'Horror',
            'Puzzle', 'Platformer', 'Indie', 'Multiplayer', 'Open World',
        ];

        foreach ($genres as $name) {
            Genre::firstOrCreate(
                ['name' => $name],
                ['slug' => Str::slug($name)]
            );
        }
    }
}