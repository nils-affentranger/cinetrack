<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/types.json");
        $data = json_decode($json);

        foreach ($data as $obj) {
            Type::create([
                'name' => $obj->name,
                'description' => $obj->description,
            ]);
        }
    }
}
