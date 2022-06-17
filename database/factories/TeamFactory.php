<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Team;

class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Team::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'user_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
