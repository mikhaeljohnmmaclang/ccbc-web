<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'       => "Admin",
            'email'      => "admin@mail.com",
            'role'       => "Admin",
            'password'   => Hash::make('123123123'),
            'status'     => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'name'       => "Director",
            'email'      => "director@mail.com",
            'role'       => "Director",
            'password'   => Hash::make('123123123'),
            'status'     => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
