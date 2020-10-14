<?php

namespace Database\Seeders;

use App\Models\TimerSound;
use Illuminate\Database\Seeder;

class TimerSoundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TimerSound::factory()->create([
            'name' => 'Magic Mallet',
            'path' => '/audio/magic-mallet.wav',
        ]);

        TimerSound::factory()->create([
            'name' => 'Birds Chirping',
            'path' => '/audio/birds-chirping.wav',
        ]);

        TimerSound::factory()->create([
            'name' => 'Ringing Bell',
            'path' => '/audio/ringing-bell.wav',
        ]);
    }
}
