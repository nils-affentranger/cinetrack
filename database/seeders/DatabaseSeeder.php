<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CinemaChainSeeder::class,
            TypeSeeder::class,
            CinemaSeeder::class,
            AuditoriumSeeder::class,
            MovieSeeder::class,
            CinemaTypePriceSeeder::class,
            CinemaPriceHistorySeeder::class,
            VisitSeeder::class,
        ]);
    }
}
