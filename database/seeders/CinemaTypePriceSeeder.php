<?php

namespace Database\Seeders;

use App\Models\CinemaChain;
use App\Models\CinemaTypePrice;
use App\Models\Type;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CinemaTypePriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/cinema_type_prices.json");
        $data = json_decode($json);

        foreach ($data as $obj) {
            $cinemaChain = CinemaChain::where('name', $obj->cinema_chain)->first();
            $type = Type::where('name', $obj->type)->first();

            if (!$cinemaChain || !$type) {
                $this->command->info("Skipping price: Cinema Chain {$obj->cinema_chain} or Ticket Type {$obj->ticket_type} not found.");
                continue;
            }

            CinemaTypePrice::create([
                'cinema_chain_id' => $cinemaChain->id,
                'type_id' => $type->id,
                'surcharge' => $obj->surcharge,
                'effective_from' => $obj->effective_from,
                'effective_to' => $obj->effective_to,
            ]);
        }
    }
}
