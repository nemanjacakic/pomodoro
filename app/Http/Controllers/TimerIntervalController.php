<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimerInterval;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
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
        if ( $request->intervals !== null ) {
            $intervalArrayValidator = Validator::make($request->all(), [
                    'intervals.*.duration' => ['required', 'regex:/^[0-9]{2}:[0-9]{2}:[0-9]{2}$/'],
                ],[
                    'intervals.*.duration.required' => 'All intervals need to have a duration',
                    'intervals.*.duration.regex' => 'All intervals durations need to be in the format HH:mm:ss'
                ]
            );

            if ( $intervalArrayValidator->fails() ) {
                $errors = $intervalArrayValidator->errors()->all();

                return $this->respondWithErrorWrongArguments( ['errors' => $errors]);
            }

            $intervals = array_map( function($item) {
                $item["duration"] = getSeconds($item["duration"]);

                return $item;

            }, $request->intervals );

            $intervals = auth()->user()->timerIntervals()->createMany($intervals);

            $response = TimerIntervalResource::collection($intervals);

            return $this->respondWithData($response, Response::HTTP_CREATED);
        }

        $intervalValidator = Validator::make($request->all(), [
                'duration' => ['required', 'regex:/^[0-9]{2}:[0-9]{2}:[0-9]{2}$/'],
            ],[
                'duration.required' => 'Interval need to have a duration',
                'duration.regex' => 'Interval durations needs to be in the format HH:mm:ss'
            ]
        );

        if ( $intervalValidator->fails() ) {
            return $this->respondWithErrorWrongArguments($intervalValidator->errors());
        }

        $interval = auth()->user()->timerIntervals()->create([
            'timer_id' => $request->timer_id,
            'title' => $request->title,
            'duration' => getSeconds($request->duration)
        ]);

        $response = new TimerIntervalResource($interval);

        return $this->respondWithData($response, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TimerInterval  $timerInterval
     * @return \Illuminate\Http\Response
     */
    public function show(TimerInterval $timerInterval)
    {
        $this->authorize('access', $timerInterval);

        return $this->respondWithData(new TimerIntervalResource($timerInterval));
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
        $this->authorize('access', $timerInterval);

        $this->validate($request, [
            'duration' => ['required', 'regex:/^[0-9]{2}:[0-9]{2}:[0-9]{2}$/'],
            ],[
                'duration.required' => 'Interval need to have a duration',
                'duration.regex' => 'Interval durations needs to be in the format HH:mm:ss'
        ]);

        $timerInterval->update([
            'timer_id' => $request->timer_id,
            'title' => $request->title,
            'duration' => getSeconds($request->duration)
        ]);

        return $this->respondWithData(new TimerIntervalResource($timerInterval));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TimerInterval  $timerInterval
     * @return \Illuminate\Http\Response
     */
    public function destroy(TimerInterval $timerInterval)
    {
        $this->authorize('access', $timerInterval);

        $timerInterval->delete();

        return $this->respondWithData(new TimerIntervalResource($timerInterval));
    }
}
