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
       User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@example.com'
        ]);

        $this->call(TimerSoundSeeder::class);
    }
}
