<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Categories::all();

        User::factory(7)->create()
            ->each(function ($user) use ($categories) {
                // Интересующие категории
                $user->categories()->attach(
                    $categories->random(rand(1, 3))->pluck('id')->toArray()
                );
                $user->role_id = Roles::all()->random(rand(1, 2))->pluck('id');
                $allUserIds = User::all()->pluck('id');
                $authorsIds = $allUserIds->reject(function ($id) use ($user) {
                return $id === $user->id;
                })->random(rand(1, 3))->toArray();

                $user->authors()->attach($authorsIds);
            });
    }
}
