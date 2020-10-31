<?php

namespace App\Http\Controllers;

use App\Models\Timer;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use App\Http\Resources\TimerResource;

class TimerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->respondWithData(
                TimerResource::collection(
                    auth()->user()->timers()->orderBy('order')->get()
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
        $request->validate([
            'name' => ['required','max:255'],
            'duration' => ['required', 'regex:/^[0-9]{2}:[0-9]{2}:[0-9]{2}$/']
        ]);

        $timer = auth()->user()->timers()->create([
            'name' => $request->name,
            'duration' => getSeconds($request->duration),
            'order' => $request->order !== '' ? $request->order : 0
        ]);

        return $this->respondWithData(
            new TimerResource($timer)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Timer  $timer
     * @return \Illuminate\Http\Response
     */
    public function show(Timer $timer)
    {
        $this->authorize('access', $timer);

        return $this->respondWithData(new TimerResource($timer));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Timer  $timer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Timer $timer)
    {
        $request->validate([
            'name' => ['required','max:255'],
            'duration' => ['required', 'regex:/^[0-9]{2}:[0-9]{2}:[0-9]{2}$/']
        ]);

        $timer->update(
            [
                'name' => $request->name,
                'duration' => getSeconds($request->duration),
                'order' => $request->order
            ]
        );

        return $this->respondWithData(new TimerResource($timer));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Timer  $timer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Timer $timer)
    {
        $this->authorize('access', $timer);

        $timer->delete();

        return $this->respondWithData(new TimerResource($timer));
    }
}
