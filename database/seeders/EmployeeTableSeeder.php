<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::create([
            'agency_id' => 1,
            'position_id' => 1,
            'name' => 'RETNO LAKORO',
            'nip' => 199411292022031009,
            'email' => 'retno.lakoro@bonebolangokab.go.id',
        ]);
    }
}
