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
            TicketTypeSeeder::class,
            CinemaSeeder::class,
            AuditoriumSeeder::class,
            MovieSeeder::class,
            CinemaTicketTypePriceSeeder::class,
            CinemaPriceHistorySeeder::class,
            VisitSeeder::class,
        ]);
    }
}
