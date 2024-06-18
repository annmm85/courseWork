<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        Roles::factory()->create([
            'name' => 'admin'
        ]);

        Roles::factory()->create([
            'name' => 'user'
        ]);
    }
}
