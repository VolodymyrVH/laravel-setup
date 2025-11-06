<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('projects')->insert([
            ['name' => 'Project A', 'owner_id' => 1],
            ['name' => 'Project B', 'owner_id' => 2],
            ['name' => 'Project C', 'owner_id' => 3],
            ['name' => 'Project D', 'owner_id' => 1],
            ['name' => 'Project E', 'owner_id' => 2],
        ]);
    }
}
