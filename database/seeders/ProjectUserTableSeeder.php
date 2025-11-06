<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProjectUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('project_user')->insert([
            ['project_id' => 1, 'user_id' => 2, 'role' => 'member'],
            ['project_id' => 1, 'user_id' => 3, 'role' => 'member'],
            ['project_id' => 2, 'user_id' => 1, 'role' => 'member'],
            ['project_id' => 3, 'user_id' => 2, 'role' => 'member'],
            ['project_id' => 4, 'user_id' => 5, 'role' => 'member'],
        ]);

    }
}
