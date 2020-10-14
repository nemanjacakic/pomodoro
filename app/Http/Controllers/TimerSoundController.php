<?php

namespace App\Http\Controllers;

use App\Models\TimerSound;
use App\Http\Resources\TimerSoundResource;

class TimerSoundController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->respondWithData(
                TimerSoundResource::collection(
                    TimerSound::all()
                    )
            );
    }
}
