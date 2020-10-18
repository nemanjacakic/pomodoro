<?php

namespace App\Http\Controllers;

use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use App\Models\TimerInterval;
use Illuminate\Http\Response;
use App\Http\Resources\TimerIntervalResource;

class TimerIntervalController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->respondWithData(
                TimerIntervalResource::collection(
                    auth()->user()->timerIntervals()->with('timer')->latest()->get()
                    )
            );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $intervals = array_map( function($item) {
            $item["duration"] = CarbonInterval::createFromFormat('i:s', $item["duration"])->totalSeconds;

            return $item;

        }, $request->intervals );

        auth()->user()->timerIntervals()->createMany($intervals);

        return $this->respondWithData('success', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TimerInterval  $timerInterval
     * @return \Illuminate\Http\Response
     */
    public function show(TimerInterval $timerInterval)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TimerInterval  $timerInterval
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TimerInterval $timerInterval)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TimerInterval  $timerInterval
     * @return \Illuminate\Http\Response
     */
    public function destroy(TimerInterval $timerInterval)
    {
        $timerInterval->delete();

        return $this->respondWithData(new TimerIntervalResource($timerInterval));
    }
}
