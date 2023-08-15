<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attendance\{StoreAttendanceRequest, UpdateAttendanceRequest};
use App\Models\{Attendance, Employee};
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{

    private $radius = 100 / 1.609; // 100 meter

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
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAttendanceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttendanceRequest $request)
    {
        $location = Location::get();

        $attr = $request->validated();

        // Get auth user
        $username = Auth::user()->username;
        $userInfo = Employee::where('nip', $username)->first();

        // Check location
        // $latitude = $userInfo->agency->latitude;
        // $longitude = $userInfo->agency->longitude;
        // $distance = $this->haversineGreatCircleDistance($latitude, $longitude, $location->latitude, $location->longitude);

        echo '<pre>';
        var_dump($location);
        echo '</pre>';

        // if ($distance > $this->radius) {
        //     // return response()->json(['message' => 'Anda tidak berada di lokasi presensi.'], 400);
        // } else {
        //     // return response()->json(['message' => 'Anda berada di lokasi presensi.'], 200);
        // }

        // Create a new attendance record
        // $attendance = new Attendance;
        // $attendance->user_id = $user->id;
        // $attendance->latitude = $location->latitude;
        // $attendance->longitude = $location->longitude;
        // $attendance->photo = $attr['photo']->store('selfies');
        // $attendance->save();

        // Return a success response
        // return response()->json(['message' => 'Check-in successful!'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAttendanceRequest  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }

    private function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) * sin($latDelta / 2) + cos($latFrom) * cos($latTo) * sin($lonDelta / 2) * sin($lonDelta / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = 6371 * $c;

        // return distance in km
        return $distance;
    }
}
