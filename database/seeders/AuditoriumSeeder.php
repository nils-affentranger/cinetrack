<?php

namespace Database\Seeders;

use App\Models\Auditorium;
use App\Models\Cinema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class AuditoriumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/auditoriums.json");
        $data = json_decode($json);

        foreach ($data as $obj) {
            $cinema = Cinema::where('name', $obj->cinema)->first();
            if (!$cinema) {
                $this->command->info("Cinema {$obj->cinema} not found.  Skipping auditorium {$obj->name}.");
                continue;
            }

            Auditorium::create([
                'cinema_id' => $cinema->id,
                'name' => $obj->name,
                'description' => $obj->description,
            ]);
        }
    }
}
