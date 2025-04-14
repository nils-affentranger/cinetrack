<?php

namespace Database\Seeders;

use App\Models\CinemaChain;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CinemaChainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function run()
    {
        $json = File::get("database/data/cinema_chains.json");
        $data = json_decode($json);

        foreach ($data as $obj) {
            CinemaChain::create([
                'name' => $obj->name,
                'description' => $obj->description,
            ]);
        }
    }
}
