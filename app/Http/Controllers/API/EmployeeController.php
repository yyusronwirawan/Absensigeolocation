<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\{StoreEmployeeRequest, UpdateEmployeeRequest};
use App\Models\{Employee, User};
use Illuminate\Support\Facades\{DB, Hash};

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::with('agency', 'position')->latest()->get();
        return response()->json([
            'status' => true,
            'agencies' => $employees
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEmployeeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeRequest $request)
    {
        try {
            DB::beginTransaction();

            $employee = Employee::create($request->all());
            $user = User::create([
                'name' => $employee->name,
                'username' => $employee->nip,
                'email' => $employee->email,
                'password' => Hash::make($request->password),
                'status' => $request->status,
            ]);

            $user->assignRole($request->role);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil ditambah',
                'employee' => $employee,
                'user' => $user
            ], 200);
        } catch (\Exception $exp) {
            DB::rollBack();

            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
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
        return response()->json($employee->load('agency:id,name', 'position:id,name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEmployeeRequest  $request
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

            $user->assignRole($request->role);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diedit',
                'employee' => $employee,
                'user' => $user
            ], 200);
        } catch (\Exception $exp) {
            DB::rollBack();

            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
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

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus',
            ], 200);
        } catch (\Exception $exp) {
            DB::rollBack();

            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
        }
    }
}
