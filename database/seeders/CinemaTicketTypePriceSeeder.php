<?php

namespace Database\Seeders;

use App\Models\CinemaChain;
use App\Models\CinemaTicketTypePrice;
use App\Models\TicketType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CinemaTicketTypePriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/cinema_ticket_type_prices.json");
        $data = json_decode($json);

        foreach ($data as $obj) {
            $cinemaChain = CinemaChain::where('name', $obj->cinema_chain)->first();
            $ticketType = TicketType::where('name', $obj->ticket_type)->first();

            if (!$cinemaChain || !$ticketType) {
                $this->command->info("Skipping price: Cinema Chain {$obj->cinema_chain} or Ticket Type {$obj->ticket_type} not found.");
                continue;
            }

            CinemaTicketTypePrice::create([
                'cinema_chain_id' => $cinemaChain->id,
                'ticket_type_id' => $ticketType->id,
                'surcharge' => $obj->surcharge,
                'effective_from' => $obj->effective_from,
                'effective_to' => $obj->effective_to,
            ]);
        }
    }
}
