<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Http\Requests\Agency\{StoreAgencyRequest, UpdateAgencyRequest};

class AgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $agency = Agency::latest()->get();
            return datatables()->of($agency)
                ->addIndexColumn()
                ->addColumn('action', 'admin.agency.include.action')
                ->toJson();
        }

        return view('admin.agency.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.agency.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAgencyRequest $request)
    {
        Agency::create($request->all());

        return redirect()->route('agency.index')
            ->with('success', 'Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Agency  $agency
     * @return \Illuminate\Http\Response
     */
    public function show(Agency $agency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Agency  $agency
     * @return \Illuminate\Http\Response
     */
    public function edit(Agency $agency)
    {
        return view('admin.agency.edit', compact('agency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Agency  $agency
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAgencyRequest $request, Agency $agency)
    {
        $agency->update($request->all());

        return redirect()->route('agency.index')
            ->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agency  $agency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agency $agency)
    {
        try {
            $agency->delete();

            return redirect()->back()
                ->with('success', 'Data Berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('error', $th->getMessage());
        }
    }

    public function select()
    {
        $data = Agency::where('name', 'LIKE', '%' . request('q') . '%')->paginate(10);
        return response()->json($data);
    }
}
