<?php

namespace Database\Seeders;

use App\Models\Boxes;
use App\Models\Categories;
use App\Models\Comments;
use App\Models\Notifies;
use App\Models\Publishs;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PublishsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Предполагается, что категории и ящики уже созданы
        $categories = Categories::all();
        $boxes = Boxes::all();
        $users = User::all();

        $users->each(function ($user) use ($categories, $boxes) {
            Publishs::factory(3)->create(['user_id' => $user->id])
                ->each(function ($publish) use ($categories, $boxes) {

                    $publish->categories()->attach(
                        $categories->random(rand(1, 3))->pluck('id')
                    );
                    $publish->boxes()->attach(
                        $boxes->random(rand(1, 2))->pluck('id')
                    );
                    $users = User::all();
                    // Создаем комментарии и связываем их с рандомными пользователями
                    Comments::factory(rand(2, 5))->make()->each(function ($comment) use ($publish, $users) {
                        $comment->publish_id = $publish->id;
                        $comment->user_id = $users->random()->id;
                        $comment->save();
                    });
                });
        });
    }
}
