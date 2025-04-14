<?php

namespace Database\Seeders;

use App\Models\Auditorium;
use App\Models\Cinema;
use App\Models\Movie;
use App\Models\TicketType;
use App\Models\Visit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class VisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/visits.json");
        $data = json_decode($json);

        foreach ($data as $obj) {
            $movie = Movie::where('title', $obj->movie)->first();
            $cinema = Cinema::where('name', $obj->cinema)->first();
            $auditorium = Auditorium::where('name', $obj->auditorium)
                ->where('cinema_id', $cinema->id ?? 0)
                ->first();
            $ticketType = TicketType::where('name', $obj->ticket_type)->first();

            if (!$movie || !$cinema || !$auditorium || !$ticketType) {
                $this->command->info("Skipping visit:  Missing movie, cinema, auditorium, or ticket type.");
                continue;
            }

            Visit::create([
                'movie_id' => $movie->id,
                'cinema_id' => $cinema->id,
                'auditorium_id' => $auditorium->id,
                'ticket_type_id' => $ticketType->id,
                'visit_date' => $obj->visit_date,
                'row' => $obj->row,
                'seat' => $obj->seat,
                'price' => $obj->price,
            ]);
        }
    }
}
