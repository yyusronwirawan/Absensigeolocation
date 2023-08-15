<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PositionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::create([
            'name' => 'Pranata Komputer',
        ]);
        Position::create([
            'name' => 'Kepala Dinas',
        ]);
        Position::create([
            'name' => 'Kasubag Kepegawaian',
        ]);
    }
}
