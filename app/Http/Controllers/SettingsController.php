<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Resources\SettingsResource;
use App\Http\Services\SettingsService;
use App\Http\Resources\SettingsCollection;

class SettingsController extends ApiController
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->respondWithData(new SettingsCollection(auth()->user()->settings()->get()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function show(Settings $settings)
    {
        return $this->respondWithData(new SettingsResource($settings));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $settings = $this->settingsService->getAvailableSettings($request->all());

        $request->validate($this->settingsService->getValidationRules($settings));

        $this->settingsService->update($settings);

        return $this->respondWithData(['success' => true ]);
    }
}
