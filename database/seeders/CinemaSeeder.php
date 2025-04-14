<?php

namespace Database\Seeders;

use App\Models\Cinema;
use App\Models\CinemaChain;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CinemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/cinemas.json");
        $data = json_decode($json);

        foreach ($data as $obj) {
            $cinemaChain = CinemaChain::where('name', $obj->cinema_chain)->first();
            if (!$cinemaChain) {
                $this->command->info("Cinema Chain {$obj->cinema_chain} not found.  Skipping cinema {$obj->name}.");
                continue;
            }

            Cinema::create([
                'cinema_chain_id' => $cinemaChain->id,
                'name' => $obj->name,
                'location' => $obj->location,
                'description' => $obj->description,
            ]);
        }
    }
}
