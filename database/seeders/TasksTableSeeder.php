<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tasks')->insert([
            ['project_id' => 1, 'author_id' => 1, 'assignee_id' => 2, 'title' => 'Task 1', 'description' => 'Description 1', 'status' => 'open', 'priority' => 'high', 'due_date' => '2025-11-15'],
            ['project_id' => 1, 'author_id' => 2, 'assignee_id' => 3, 'title' => 'Task 2', 'description' => 'Description 2', 'status' => 'in_progress', 'priority' => 'medium', 'due_date' => '2025-11-16'],
        ]);
    }
}
