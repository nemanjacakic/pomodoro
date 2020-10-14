<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimerInterval;
use Illuminate\Http\Response;

class TimerIntervalController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        auth()->user()->timerIntervals()->createMany($request->intervals);

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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TimerInterval  $timerInterval
     * @return \Illuminate\Http\Response
     */
    public function edit(TimerInterval $timerInterval)
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
        //
    }
}
