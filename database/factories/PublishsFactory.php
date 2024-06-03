<?php

namespace Database\Factories;

use App\Models\Publishs;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Publishs>
 */
class PublishsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Publishs::class;
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(2, true),
            'desc' => $this->faker->paragraph(1),
            'image' => $this->faker->imageUrl(),
            'user_id' => $this->faker->numberBetween(1, 7),
        ];
    }


}
