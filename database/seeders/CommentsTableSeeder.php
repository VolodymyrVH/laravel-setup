<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('comments')->insert([
            ['task_id' => 1, 'author_id' => 2, 'body' => 'First comment'],
            ['task_id' => 1, 'author_id' => 3, 'body' => 'Second comment'],
            ['task_id' => 2, 'author_id' => 1, 'body' => 'Another comment'],
        ]);

    }
}
