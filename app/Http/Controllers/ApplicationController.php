<?php

namespace App\Http\Controllers;

use App\Http\Requests\Application\StoreApplicationRequest;
use App\Http\Requests\Application\UpdateApplicationRequest;
use App\Models\Application;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
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

        $applicationQuery = Application::query();

        $applications = $applicationQuery->with('employee')->latest();

        if (auth()->user()->roles->first()->name == 'Super Admin') {
            $applications->latest()->get();
        } elseif (auth()->user()->roles->first()->name == 'Admin OPD') {
            $applications->whereHas('employee', function ($query) use ($adminInfo) {
                $query->where('agency_id', $adminInfo->agency_id);
            })->latest()->get();
        } else {
            $applications->where('employee_id', auth()->user()->id)->latest();
        }

        if (request()->ajax()) {
            return dataTables()->of($applications)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->employee ? $row->employee->name : '-';
                })
                ->addColumn('type', function ($row) {
                    return $row->type();
                })
                ->addColumn('start_date', function ($row) {
                    return $row->start_date;
                })
                ->addColumn('end_date', function ($row) {
                    return $row->end_date;
                })
                ->addColumn('status', function ($row) {
                    return $row->status();
                })
                ->addColumn('action', 'admin.application.include.action')
                ->toJson();
        }

        return view('admin.application.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.application.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApplicationRequest $request)
    {
        $attr = $request->validated();

        if ($request->file('file') && $request->file('file')->isValid()) {

            $filename = $request->file('file')->hashName();
            $request->file('file')->storeAs('upload/pengajuan', $filename, 'public');

            $attr['file'] = $filename;
        }

        Application::create($attr);

        return redirect()->route('application.index')
            ->with('success', 'Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        $application->load('employee:id,name');
        return view('admin.application.show', compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        return view('admin.application.edit', compact('application'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateApplicationRequest $request, Application $application)
    {
        $attr = $request->validated();

        if ($request->file('file') && $request->file('file')->isValid()) {

            $path = storage_path('app/public/upload/pengajuan/');
            $filename = $request->file('file')->hashName();
            $request->file('file')->storeAs('upload/pengajuan', $filename, 'public');

            // delete old file from storage
            if ($application->file != null && file_exists($path . $application->file)) {
                unlink($path . $application->file);
            }

            $attr['file'] = $filename;
        }

        $application->update($attr);

        return redirect()->route('application.index')->with('success', 'Data berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        try {
            // determine path file
            $path = storage_path('app/public/upload/pengajuan/');

            // if product exist remove file from directory
            if ($application->file != null && file_exists($path . $application->file)) {
                unlink($path . $application->file);
            }

            $application->delete();
            return redirect()->route('application.index')->with('success', 'Data Berhasil Dihapus');
        } catch (\Throwable $th) {
            return redirect()
                ->route('application.index')
                ->with('error', __('Maaf, Pengajuan tidak bisa dihapus.'));
        }
    }

    public function getApprove(Application $application)
    {
        return view('admin.application.approve', compact('application'));
    }

    public function storeApprove(Request $request, Application $application)
    {
        if ($application) {
            $application->update(['status' => $request->status]);

            return redirect()->route('application.index')->with('success', 'Pengajuan berhasil diproses');
        }
    }
}
