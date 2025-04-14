<?php

namespace Database\Seeders;

use App\Models\TicketType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TicketTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/ticket_types.json");
        $data = json_decode($json);

        foreach ($data as $obj) {
            TicketType::create([
                'name' => $obj->name,
                'description' => $obj->description,
            ]);
        }
    }
}
