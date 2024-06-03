<?php

namespace Database\Seeders;

use App\Models\Notifies;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotifiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = User::all();

        $users->each(function ($user) {
            Notifies::factory(rand(1, 3))->create()
                ->each(function ($notification) use ($user) {
                    $user->notifies()->attach($notification->id);
                });
        });
    }
}
