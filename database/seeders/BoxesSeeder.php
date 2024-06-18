<?php

namespace Database\Seeders;

use App\Models\Boxes;
use Illuminate\Database\Seeder;

class BoxesSeeder extends Seeder
{
    public function run()
    {
        Boxes::factory()->count(5)->create();
    }
}
