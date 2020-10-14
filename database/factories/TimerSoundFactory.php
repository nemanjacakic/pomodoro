<?php

namespace Database\Factories;

use App\Models\TimerSound;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TimerSoundFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TimerSound::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'path' => $this->faker->word,
        ];
    }
}
