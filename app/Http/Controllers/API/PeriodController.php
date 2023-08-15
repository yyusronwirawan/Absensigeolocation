<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Period;
use App\Http\Requests\Period\{StorePeriodRequest, UpdatePeriodRequest};

class PeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periods = Period::all();
        return response()->json([
            'status' => true,
            'periods' => $periods
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePeriodRequest $request)
    {
        $period = Period::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditambah',
            'period' => $period
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Period  $period
     * @return \Illuminate\Http\Response
     */
    public function show(Period $period)
    {
        return response()->json($period);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Period  $period
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePeriodRequest $request, Period $period)
    {
        $period->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diedit',
            'period' => $period
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Period  $period
     * @return \Illuminate\Http\Response
     */
    public function destroy(Period $period)
    {
        $period->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus',
        ], 200);
    }
}
