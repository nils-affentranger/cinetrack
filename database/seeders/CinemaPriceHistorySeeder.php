<?php

namespace Database\Seeders;

use App\Models\Cinema;
use App\Models\CinemaPriceHistory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CinemaPriceHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/cinema_price_history.json");
        $data = json_decode($json);

        foreach ($data as $obj) {
            $cinema = Cinema::where('name', $obj->cinema)->first();
            if (!$cinema) {
                $this->command->info("Cinema {$obj->cinema} not found.  Skipping price history.");
                continue;
            }

            CinemaPriceHistory::create([
                'cinema_id' => $cinema->id,
                'base_price' => $obj->base_price,
                'effective_from' => $obj->effective_from,
                'effective_to' => $obj->effective_to,
            ]);
        }
    }
}
