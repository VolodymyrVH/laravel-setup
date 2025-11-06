<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            ['name' => 'Vovan', 'email' => 'vovan@example.com', 'password' => Hash::make('123456')],
            ['name' => 'Tolik', 'email' => 'tolik@example.com', 'password' => Hash::make('123456')],
            ['name' => 'Kolya', 'email' => 'kolya@example.com', 'password' => Hash::make('123456')],
            ['name' => 'Vasya', 'email' => 'vasya@example.com', 'password' => Hash::make('123456')],
            ['name' => 'Denis', 'email' => 'denis@example.com', 'password' => Hash::make('123456')],
        ]);
    }
}
