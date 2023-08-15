<?php

namespace App\Http\Controllers;

use App\Models\{Application, Attendance, Employee};
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $usernameAdmin = Auth::user()->username;
        $adminInfo = Employee::where('nip', $usernameAdmin)->first();

        $data = [
            'checkRegular' => Attendance::checkAttendance(1)->first(),
            'checkAssignment' => Attendance::checkAttendance(2)->first(),
        ];

        $todayAttendance = Attendance::whereHas('employee', function ($query) use ($adminInfo) {
            $query->where('agency_id', $adminInfo->agency_id);
        })->whereDate('created_at', \Carbon\Carbon::today())
            ->orderBy('checkin_time', 'DESC')
            ->get();

        $application = Application::whereMonth('created_at', \Carbon\Carbon::now())->latest()->get();

        return view('admin.dashboard.index', compact('data', 'application', 'todayAttendance'));
    }
}
