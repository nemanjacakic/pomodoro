<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Timer;
use App\Models\Settings;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       $user = User::factory()->create([
            'first_name' => 'Nemanja',
            'last_name' => 'Cakic',
            'email' => 'nemanja.c@live.com'
        ]);

        // Timer::factory()->create([
        //     'user_id' => $user->id,
        //     'order' => 0,
        //     'name' => 'Pomodoro',
        //     'duration' => 1500
        // ]);

        // Timer::factory()->create([
        //     'user_id' => $user->id,
        //     'order' => 1,
        //     'name' => 'Short break',
        //     'duration' => 300
        // ]);

        // Timer::factory()->create([
        //     'user_id' => $user->id,
        //     'order' => 2,
        //     'name' => 'Long break',
        //     'duration' => 900
        // ]);

        // $timerSettings = [
        //     "timerSound" => true
        // ];

        // foreach ($timerSettings as $setting => $value) {
        //     Settings::factory()->create([
        //         'user_id' => $user->id,
        //         'key' => $setting,
        //         'value' => $value,
        //         'label' => 'timer'
        //     ]);
        // }
    }
}
