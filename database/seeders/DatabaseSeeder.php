<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategoriesSeeder::class,
            RolesSeeder::class,
            UserSeeder::class,
            BoxesSeeder::class,
            PublishsSeeder::class,
            NotifiesSeeder::class,
        ]);
    }
}
