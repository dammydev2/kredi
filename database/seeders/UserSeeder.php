<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'uid' => Str::orderedUuid(),
                'name' => Str::random(10),
                'email' => 'admin1@kredi.com',
                'password' => Hash::make('password'),
                'type' => 'admin'
            ],
            [
                'uid' => Str::orderedUuid(),
                'name' => Str::random(10),
                'email' => 'admin2@kredi.com',
                'password' => Hash::make('password'),
                'type' => 'admin'
            ],
        ];

        DB::table('users')->insert($data);
    }
}
