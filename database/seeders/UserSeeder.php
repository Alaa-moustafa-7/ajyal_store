<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=>'Mohamed Safadi',
            'email'=>'m@safasi.ps',
            'password'=> Hash::make('password'),
            'phone_number'=>'0123456789',
        ]);
        DB::table('users')->insert([
            'name'=>'System Admin',
            'email'=>'sys@safasi.ps',
            'password'=> Hash::make('password'),
            'phone_number'=>'012345678910',
        ]);
    }
}
