<?php

namespace Database\Factories;

use App\Models\Timer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TimerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Timer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => Str::ucfirst($this->faker->word),
            'duration' => $this->faker->numberBetween(60, 3600)
        ];
    }
}
