<?php

namespace App\Http\Controllers;

use App\Models\Timer;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use App\Http\Services\SettingsService;
use Illuminate\Support\Facades\Validator;

class SettingsModalController extends ApiController
{

    private $settingsService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SettingsService $settingsService)
    {
      $this->settingsService = $settingsService;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Timer  $timer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $errors = [];

        if ($request->has('timers')) {
            $timerValidator = Validator::make($request->all(), [
                    'timers.*.name' => ['required','max:255'],
                    'timers.*.duration' => ['required', 'regex:/^[0-9]{2}:[0-9]{2}:[0-9]{2}$/'],
                ],[
                    'timers.*.name.required' => 'All timers need to have a name',
                    'timers.*.name.max' => 'All timers names need to be 255 characters maximum',

                    'timers.*.duration.required' => 'All timers need to have a duration',
                    'timers.*.duration.regex' => 'All timers durations need to be in the format HH:mm:ss'
                ]
            );
        }

        if ($request->has('settings')) {
            $settings = $this->settingsService->getAvailableSettings($request->settings);

            $settingsValidator = Validator::make($request->settings, $this->settingsService->getValidationRules($settings));
        }

        if ( $timerValidator->fails() || $settingsValidator->fails() ) {
            $timersErrors = [
                'timers' => $timerValidator->errors()->all()
            ];

            $settingsErrors = [
                'settings' => $settingsValidator->errors()->all()
            ];

            $errors = array_merge($errors, $timersErrors, $settingsErrors);

            return $this->respondWithErrorWrongArguments($errors);
        }

        if ($request->has('timers')) {
            foreach ($request->timers as $timer) {
                auth()->user()->timers()->where('id', $timer["id"])->update(
                    [
                        'name' => $timer["name"],
                        'duration' => getSeconds($timer["duration"])
                    ]
                );
            }
        }

        if ($request->has('settings')) {
            $this->settingsService->update($settings);
        }

        return $this->respondWithData(['success' => true ]);
    }
}
