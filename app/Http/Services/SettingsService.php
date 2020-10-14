<?php

namespace App\Http\Services;

use Illuminate\Support\Collection;

class SettingsService
{

    private $settings;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->settings = collect([
            "timerSoundEnabled" => ['required', 'boolean'],
            "timerSound" => ['required'],
            "showNotifications" => ['required', 'boolean']
      ]);
    }
    // public function update(Request $request)
    // {
    //     $settings = collect($request->all())->filter( function($value, $key) {
    //         return $this->settings->has($key);
    //      });

    //     $request->validate($this->getValidationRules($settings));

    //     $settings->each( function( $value, $key ) {
    //         auth()->user()->settings()->where('key', $key)->update([
    //             'value' => $value
    //         ]);
    //     });

    //     return $this->respondWithData(['success' => true ]);
    // }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function update(Collection $settings)
    {
        $settings->each( function( $value, $key ) {
            auth()->user()->settings()->where('key', $key)->update([
                'value' => $value
            ]);
        });
    }

    public function getAvailableSettings(array $settings)
    {
        return collect($settings)->filter( function($value, $key) {
            return $this->settings->has($key);
        });
    }

    public function getValidationRules(Collection $settings)
    {
        return $this->settings->intersectByKeys($settings)->toArray();
    }
}
