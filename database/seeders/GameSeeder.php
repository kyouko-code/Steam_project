<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $games = [
            [
                'title' => 'Shadow of Valor',
                'description' => 'A dark fantasy action RPG where you forge your own legend. Explore a vast open world filled with ancient dungeons, epic boss battles, and a story shaped by your choices. Master sword and sorcery as you rise from humble origins to become the hero the realm needs.',
                'price' => 59.99,
                'discount_price' => 39.99,
                'publisher' => 'Obsidian Forge',
                'developer' => 'Obsidian Forge',
                'release_date' => '2026-03-14',
                'featured' => true,
                'genres' => ['Action', 'RPG', 'Adventure'],
            ],
            [
                'title' => 'Neon Drift',
                'description' => 'Take on the underground street racing scene in this high-octane racer set in a cyberpunk metropolis. Customize your ride with neon liveries, twin-turbo engines, and hover tech. Race through rain-slicked city streets against rival crews in adrenaline-pumping showdowns.',
                'price' => 49.99,
                'discount_price' => null,
                'publisher' => 'Pulse Interactive',
                'developer' => 'Pulse Interactive',
                'release_date' => '2026-05-22',
                'featured' => true,
                'genres' => ['Racing', 'Multiplayer'],
            ],
            [
                'title' => 'The Last Cartographer',
                'description' => 'A narrative adventure about exploring a world where maps are forbidden. As the last cartographer, chart forgotten territories, uncover hidden civilizations, and decide whether knowledge should be shared or hoarded. A beautiful hand-drawn world awaits.',
                'price' => 29.99,
                'discount_price' => 19.99,
                'publisher' => 'Lantern Studio',
                'developer' => 'Lantern Studio',
                'release_date' => '2026-01-18',
                'featured' => true,
                'genres' => ['Adventure', 'Indie', 'Puzzle'],
            ],
            [
                'title' => 'Ironclad Protocol',
                'description' => 'Command a squad of elite mech pilots in this tactical turn-based strategy game. Plan your approach, manage resources, and customize your mechs with modular weapons and armor. Survive ever-escalating threat scenarios in a militarized future.',
                'price' => 44.99,
                'discount_price' => 34.99,
                'publisher' => 'Redwire Games',
                'developer' => 'Redwire Games',
                'release_date' => '2026-04-03',
                'featured' => false,
                'genres' => ['Strategy', 'Simulation'],
            ],
            [
                'title' => 'Phantom Current',
                'description' => 'A gripping single-player shooter set on an abandoned offshore platform. Unravel the mystery of what happened to the crew while surviving waves of hostile drones. Atmospheric, tense, and relentless. Your flashlight is both a tool and a target.',
                'price' => 54.99,
                'discount_price' => null,
                'publisher' => 'Blackline Studios',
                'developer' => 'Blackline Studios',
                'release_date' => '2026-06-30',
                'featured' => true,
                'genres' => ['Shooter', 'Horror'],
            ],
            [
                'title' => 'Kingdom of Cinders',
                'description' => 'Build, manage, and defend a medieval kingdom from the ashes of a once-great empire. Allocate resources, forge alliances, and expand your territory. Every decision has weight as winter approaches and factions vie for power.',
                'price' => 39.99,
                'discount_price' => 27.99,
                'publisher' => 'Falcon House',
                'developer' => 'Falcon House',
                'release_date' => '2025-11-09',
                'featured' => false,
                'genres' => ['Strategy', 'Simulation'],
            ],
            [
                'title' => 'Velocity Strikers',
                'description' => 'Fast and furious arena combat for up to 12 players online. Choose from a roster of unique fighters, each with distinct abilities and playstyles. Learn the ropes in arcade mode, then climb the ranked ladder in competitive play.',
                'price' => 24.99,
                'discount_price' => 14.99,
                'publisher' => 'Rogue Metric',
                'developer' => 'Rogue Metric',
                'release_date' => '2025-08-21',
                'featured' => false,
                'genres' => ['Fighting', 'Multiplayer'],
            ],
            [
                'title' => 'Crystal Depths',
                'description' => 'Plunge into a bioluminescent ocean teeming with strange life. A serene yet haunting exploration sim where you catalog new species and piece together the ecosystems of the deep. Beautiful, calming, and occasionally terrifying.',
                'price' => 19.99,
                'discount_price' => null,
                'publisher' => 'Aurora Pixel',
                'developer' => 'Aurora Pixel',
                'release_date' => '2025-12-05',
                'featured' => false,
                'genres' => ['Simulation', 'Indie', 'Adventure'],
            ],
            [
                'title' => 'Beyond the Veil',
                'description' => 'An immersive open-world RPG where the boundary between the living and the dead is breaking down. Channel spirits, bargain with necromancers, and decide the fate of the ethereal plane in this ambitious, story-driven epic.',
                'price' => 64.99,
                'discount_price' => 49.99,
                'publisher' => 'Starfall Interactive',
                'developer' => 'Starfall Interactive',
                'release_date' => '2026-02-27',
                'featured' => true,
                'genres' => ['RPG', 'Open World', 'Adventure'],
            ],
            [
                'title' => 'Striker\'s Arena',
                'description' => 'The definitive multiplayer sports experience. Build your dream team, develop players, and compete in a deep career mode or take the rivalry online. Realistic physics, dynamic tactics, and pure competition from kickoff to final whistle.',
                'price' => 59.99,
                'discount_price' => 45.99,
                'publisher' => 'Goal Post Games',
                'developer' => 'Goal Post Games',
                'release_date' => '2025-09-15',
                'featured' => false,
                'genres' => ['Sports', 'Multiplayer'],
            ],
            [
                'title' => 'Contraption Lab',
                'description' => 'The ultimate physics sandbox puzzle game. Build absurd Rube Goldberg machines from hundreds of parts and get them to work — somehow. Share your contraptions with the community and try to solve theirs. There are no wrong answers, only explosions.',
                'price' => 14.99,
                'discount_price' => 9.99,
                'publisher' => 'Tin Widget Art',
                'developer' => 'Tin Widget Art',
                'release_date' => '2025-10-11',
                'featured' => false,
                'genres' => ['Puzzle', 'Indie', 'Simulation'],
            ],
            [
                'title' => 'Skyward Blade',
                'description' => 'Soar between floating islands in this acrobatic platformer. Master wall-runs, air dashes, and parries as you climb to the ever-shifting sky temples. Tight controls, gorgeous vistas, and combat that rewards precision.',
                'price' => 34.99,
                'discount_price' => null,
                'publisher' => 'Featherweight Games',
                'developer' => 'Featherweight Games',
                'release_date' => '2026-01-04',
                'featured' => false,
                'genres' => ['Platformer', 'Action', 'Adventure'],
            ],
        ];

        foreach ($games as $gameData) {
            $genreNames = $gameData['genres'];
            unset($gameData['genres']);

            $game = Game::updateOrCreate(
                ['title' => $gameData['title']],
                array_merge($gameData, [
                    'slug' => Str::slug($gameData['title']) . '-' . rand(100, 999),
                    'status' => 'active',
                ])
            );

            $genreIds = Genre::whereIn('name', $genreNames)->pluck('id');
            $game->genres()->sync($genreIds);
        }
    }
}