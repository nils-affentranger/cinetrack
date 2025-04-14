<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/movies.json");
        $data = json_decode($json);

        foreach ($data as $obj) {
            Movie::create([
                'title' => $obj->title,
                'tmdb_id' => $obj->tmdb_id,
                'poster_path' => $obj->poster_path,
                'runtime' => $obj->runtime,
            ]);
        }
    }
}
