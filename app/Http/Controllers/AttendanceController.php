<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceExport;
use App\Http\Requests\Attendance\{StoreAttendanceRequest, StoreCheckoutAttendanceRequest, UpdateAttendanceRequest};
use App\Models\{Attendance, Employee};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Storage};

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usernameAdmin = Auth::user()->username;
        $adminInfo = Employee::where('nip', $usernameAdmin)->first();

        $attendanceQuery = Attendance::query();

        $attendances = $attendanceQuery->with('user.employee')->latest();

        if (auth()->user()->roles->first()->name == 'Super Admin') {
            $attendances->get();
        } elseif (auth()->user()->roles->first()->name == 'Admin OPD' || auth()->user()->roles->first()->name == 'Atasan') {
            $attendances->whereHas('user', function ($query) use ($adminInfo) {
                $query->whereHas('employee', function ($q) use ($adminInfo) {
                    $q->where('agency_id', $adminInfo->agency_id);
                });
            })->get();
        } else {
            $attendances->where('user_id', auth()->user()->id);
        }

        if (request()->ajax()) {
            return dataTables()->of($attendances)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->employee ? $row->employee->name : '-';
                })
                ->addColumn('type', function ($row) {
                    return $row->type();
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->isoFormat('dddd, D MMMM Y');
                })
                ->addColumn('status', function ($row) {
                    return $row->status();
                })
                ->addColumn('action', 'admin.attendance.include.action')
                ->toJson();
        }

        return view('admin.attendance.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.attendance.createCheckin');
    }

    public function createCheckout(Attendance $attendance)
    {
        return view('admin.attendance.createCheckout', compact('attendance'));
    }

    public function createAssignmentCheckin()
    {
        return view('admin.attendance.createAssignmentCheckin');
    }

    public function createAssignmentCheckout(Attendance $attendance)
    {
        return view('admin.attendance.createAssignmentCheckout', compact('attendance'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttendanceRequest $request)
    {
        $radius = 1; //100 meter
        $attr = $request->validated();
        $checkinRegular = Attendance::checkAttendance(1)->first();
        $checkinAssignment = Attendance::checkAttendance(2)->first();

        // Get auth user
        $user = Auth::user();
        $userInfo = Employee::where('nip', $user->username)->first();

        // Check location
        $latitude = $userInfo->agency->latitude;
        $longitude = $userInfo->agency->longitude;
        $distance = $this->haversineDistance($attr['checkin_latitude'], $attr['checkin_longitude'], $latitude, $longitude);
        $convertDistance = number_format($distance, 2);

        if ($attr['type'] == 1) {
            if ($convertDistance >= $radius) {
                return redirect()->back()
                    ->with('toast_error', 'Anda tidak berada di lokasi presensi.');
            }

            if (\Carbon\Carbon::now()->toTimeString() > '12:00:00' && !$checkinRegular) {
                return redirect()->back()
                    ->with('toast_error', 'Maaf sudah tidak bisa melakukan absen masuk');
            }

            if ($checkinRegular || $checkinAssignment) {
                return redirect()->route('dashboard.index')
                    ->with('toast_error', 'Anda sudah melakukan absen masuk');
            }

            if (\Carbon\Carbon::now()->toTimeString() <= '07:30:00') {
                return redirect()->back()
                    ->with('toast_error', 'Maaf, belum bisa melakukan absen masuk');
            }
        } else {
            if ($convertDistance <= $radius) {
                return redirect()->back()
                    ->with('toast_error', 'Anda tidak berada di lokasi presensi.');
            }

            if (\Carbon\Carbon::now()->toTimeString() > '12:00:00' && !$checkinAssignment) {
                return redirect()->back()
                    ->with('toast_error', 'Maaf sudah tidak bisa melakukan absen masuk');
            }

            if ($checkinRegular || $checkinAssignment) {
                return redirect()->route('dashboard.index')
                    ->with('toast_error', 'Anda sudah melakukan absen masuk');
            }

            if (\Carbon\Carbon::now()->toTimeString() <= '07:30:00') {
                return redirect()->back()
                    ->with('toast_error', 'Maaf, belum bisa melakukan absen masuk');
            }
        }

        // Create a new attendance record
        $attendance = new Attendance;
        $attendance->employee_id = $user->id;
        $attendance->type = $attr['type'];
        $attendance->checkin_latitude = $attr['checkin_latitude'];
        $attendance->checkin_longitude = $attr['checkin_longitude'];
        $attendance->checkin_time = $attr['checkin_time'];
        $attendance->checkin_photo = $this->uploadPhoto($request->checkin_photo);
        $attendance->save();

        // Return a success response
        return redirect()->route('dashboard.index')
            ->with('success', 'Absen Masuk Berhasil');
    }

    public function storeCheckout(StoreCheckoutAttendanceRequest $request, Attendance $attendance)
    {
        $radius = 1; //100 meter
        $attr = $request->validated();
        $checkRegular = Attendance::checkAttendance(1)->first();
        $checkAssignment = Attendance::checkAttendance(2)->first();

        // Get auth user
        $user = Auth::user();
        $userInfo = Employee::where('nip', $user->username)->first();

        // Check location
        $latitude = $userInfo->agency->latitude;
        $longitude = $userInfo->agency->longitude;
        $distance = $this->haversineDistance($attr['checkout_latitude'], $attr['checkout_longitude'], $latitude, $longitude);
        $convertDistance = number_format($distance, 2);

        if ($request->type == 1) {
            if ($convertDistance >= $radius) {
                return redirect()->back()
                    ->with('toast_error', 'Anda tidak berada di lokasi presensi.');
            }

            if (\Carbon\Carbon::now()->toTimeString() > '20:00:00' && !$checkRegular) {
                return redirect()->back()
                    ->with('toast_error', 'Maaf sudah tidak bisa melakukan absen pulang');
            }

            if (\Carbon\Carbon::now()->toTimeString() <= '16:30:00') {
                return redirect()->back()
                    ->with('toast_error', 'Maaf, belum bisa melakukan absen pulang');
            }

            if ($checkRegular->checkout_time != NULL) {
                return redirect()->route('dashboard.index')
                    ->with('success', 'Anda sudah melakukan absen pulang');
            }
        } else {
            if ($convertDistance <= $radius) {
                return redirect()->back()
                    ->with('toast_error', 'Anda tidak berada di lokasi presensi.');
            }

            if (\Carbon\Carbon::now()->toTimeString() > '20:00:00' && !$checkAssignment) {
                return redirect()->back()
                    ->with('toast_error', 'Maaf sudah tidak bisa melakukan absen pulang');
            }


            if (\Carbon\Carbon::now()->toTimeString() <= '16:30:00') {
                return redirect()->back()
                    ->with('toast_error', 'Maaf, belum bisa melakukan absen pulang');
            }

            if ($checkAssignment->checkout_time != NULL) {
                return redirect()->route('dashboard.index')
                    ->with('success', 'Anda sudah melakukan absen pulang');
            }

            if (!$checkRegular || !$checkAssignment) {
                if ($checkAssignment->checkin_time == NULL) {
                    return redirect()->route('dashboard.index')
                        ->with('success', 'Maaf, anda belum melakukan absen masuk');
                }
            }
        }

        // Update attendance record
        $attendance->update([
            'checkout_latitude' => $attr['checkout_latitude'],
            'checkout_longitude' => $attr['checkout_longitude'],
            'checkout_time' => $attr['checkout_time'],
            'checkout_photo' => $this->uploadPhoto($request->checkout_photo),
        ]);

        // Return a success response
        return redirect()->route('dashboard.index')
            ->with('success', 'Absen Pulang Berhasil');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        $attendanceQuery = Attendance::query();
        $month = request()->filter_month;
        $year = request()->filter_year;

        if (!empty($month && $year)) {
            $attendanceQuery->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
        }

        $attendances = $attendanceQuery->with('employee')
            ->where('employee_id', $attendance->employee_id)
            ->latest();

        if (request()->ajax()) {
            return dataTables()->of($attendances)
                ->addIndexColumn()
                ->addColumn('type', function ($row) {
                    return $row->type();
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->isoFormat('dddd, D MMMM Y');
                })
                ->addColumn('status', function ($row) {
                    return $row->status();
                })
                ->editColumn('photo', function (Attendance $attendance) {
                    $checkin_photo = $attendance->checkin_photo;
                    $checkout_photo = $attendance->checkout_photo;
                    return '
                    <a class="btn btn-warning btn-sm"  href="' . asset('storage/upload/absen/' . $checkin_photo) . '" target="_blank">Absen Masuk</a>
                    <a class="btn btn-warning btn-sm"  href="' . asset('storage/upload/absen/' . $checkout_photo) . '" target="_blank">Absen Pulang</a>
                    ';
                })
                ->rawColumns(['photo'])
                ->toJson();
        }

        return view('admin.attendance.show', compact('attendance'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        return view('admin.attendance.edit', compact('attendance'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        $attr = $request->validated();

        $attendance->update($attr);

        return redirect()->route('attendance.index')
            ->with('success', 'Data berhasil diedit');
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

    public function exportAttendance(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        $id = $request->user;

        if ($month && $year) {
            return (new AttendanceExport($month, $year, $id))->download('Data absen bulan' . $month  . '-' . $year . '.xlsx');
        } else {
            return redirect()->back()->with('toast_error', 'Maaf, tidak bisa export data');
        }
    }

    private function haversineDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371)
    {
        // convert from degrees to radians
        $latDelta = deg2rad($latitudeTo - $latitudeFrom);
        $lonDelta = deg2rad($longitudeTo - $longitudeFrom);

        $a = sin($latDelta / 2) * sin($latDelta / 2) + cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * sin($lonDelta / 2) * sin($lonDelta / 2);
        $c = 2 * asin(sqrt($a));

        return $earthRadius * $c;
    }

    private function uploadPhoto($fileInputName)
    {
        $photo = $fileInputName;

        $image_parts = explode(";base64,", $photo);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.png';

        // $file = $folderPath . $fileName;
        Storage::disk('public')->put('upload/absen/' . $fileName, $image_base64);

        return $fileName;
    }
}
