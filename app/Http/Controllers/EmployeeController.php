<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\{StoreEmployeeRequest, UpdateEmployeeRequest};
use App\Models\{Agency, Employee, User, Position};
use Illuminate\Support\Facades\{DB, Hash};
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $employee = Employee::latest()->get();
            return datatables()->of($employee)
                ->addIndexColumn()
                ->addColumn('position', function ($row) {
                    return $row->position ? $row->position->name : '-';
                })
                ->addColumn('action', 'admin.employee.include.action')
                ->toJson();
        }

        return view('admin.employee.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        if ($user->hasRole('Admin OPD')) {
            $roles = Role::whereIn('name', ['Admin OPD', 'Pegawai'])->get();
        } else {
            $roles = Role::get();
        }
        $positions = Position::get();
        $agencies = Agency::get();
        return view('admin.employee.create', compact('roles', 'positions', 'agencies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeRequest $request)
    {
        try {
            DB::beginTransaction();


            $attr = $request->validated();
            $employee = Employee::create($attr);

            $user = User::create([
                'employee_id' => $employee->id,
                'name' => $employee->name,
                'username' => $employee->nip,
                'email' => $employee->email,
                'password' => Hash::make($attr['password']),
                'status' => $attr['status'],
            ]);

            $user->assignRole($request->role);

            DB::commit();

            return redirect()->route('employee.index')
                ->with('success', 'Data berhasil ditambah');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->route('employee.index')
                ->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $roles = Role::get();
        $positions = Position::get();
        $agencies = Agency::get();

        return view('admin.employee.edit', compact('roles', 'employee', 'positions', 'agencies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        try {
            DB::beginTransaction();

            $user = User::where('username', $employee->nip)->firstOrFail();
            $employee->update($request->all());
            $user->update([
                'name' => $employee->name,
                'username' => $employee->nip,
                'email' => $employee->email,
                'password' => Hash::make($request->password),
                'status' => $request->status,
            ]);

            $user->syncRoles($request->role);

            DB::commit();

            return redirect()->route('employee.index')
                ->with('success', 'Data berhasil diedit');
        } catch (\Exception $exp) {
            DB::rollBack();

            return redirect()->route('employee.index')
                ->with('error', $exp->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        try {
            DB::beginTransaction();
            $user = User::where('username', $employee->nip)->firstOrFail();
            $user->delete();
            $employee->delete();

            DB::commit();

            return redirect()->route('employee.index')
                ->with('success', 'Data berhasil dihapus');
        } catch (\Exception $exp) {
            DB::rollBack();

            return redirect()->route('employee.index')
                ->with('error', $exp->getMessage());
        }
    }
}
