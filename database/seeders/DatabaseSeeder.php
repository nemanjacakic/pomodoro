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

        $this->call(TimerSoundSeeder::class);
    }
}
