<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'RETNO LAKORO',
            'username' => 199411292022031009,
            'email' => 'retno.lakoro@bonebolangokab.go.id',
            'password' => Hash::make('123456'),
            'status' => 1,
        ]);
        
    }
}
