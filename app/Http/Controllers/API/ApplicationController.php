<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\{StoreApplicationRequest, UpdateApplicationRequest};
use App\Models\Application;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applications = Application::with('user')->latest()->get();
        return response()->json([
            'status' => true,
            'applications' => $applications
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreApplicationRequest  $request
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

        $application = Application::create($attr);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditambah',
            'application' => $application
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        return response()->json($application);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateApplicationRequest  $request
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

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diedit',
            'application' => $application
        ], 200);
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

            // if application exist remove file from directory
            if ($application->file != null && file_exists($path . $application->file)) {
                unlink($path . $application->file);
            }

            $application->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus',
            ], 200);
        } catch (\Throwable $th) {
            return response([
                'message' => $th->getMessage(),
                'status' => 'failed'
            ], 400);
        }
    }
}
