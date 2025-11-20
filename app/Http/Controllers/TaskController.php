<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;

class TaskController extends Controller
{
    public function index(Project $project, Request $request)
    {
        $user = $request->user();

        if ($project->owner_id !== $user->id && !$project->users->contains($user->id)) {
            return response()->json(['message' => 'Enter is closed'], 403);
        }

        $tasks = $project->tasks()->get();
        return response()->json($tasks);
    }

    public function store(Project $project, Request $request)
    {
        $user = $request->user();

        if ($project->owner_id !== $user->id && !$project->users->contains($user->id)) {
            return response()->json(['message' => 'Enter is closed'], 403);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
            'priority' => 'nullable|string',
            'due_date' => 'nullable|date',
            'assignee_id' => 'nullable|exists:users,id',
        ]);

        $task = Task::create([
            'project_id' => $project->id,
            'author_id' => $user->id,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'] ?? 'new',
            'priority' => $data['priority'] ?? 'normal',
            'due_date' => $data['due_date'] ?? null,
            'assignee_id' => $data['assignee_id'] ?? null,
        ]);

        return response()->json($task, 201);
    }

    public function show(Task $task, Request $request)
    {
        $user = $request->user();
        $project = $task->project;

        if ($project->owner_id !== $user->id && !$project->users->contains($user->id)) {
            return response()->json(['message' => 'Enter is closed'], 403);
        }

        return response()->json($task);
    }

    public function update(Task $task, Request $request)
    {
        $user = $request->user();
        $project = $task->project;

        if ($task->author_id !== $user->id && $project->owner_id !== $user->id) {
            return response()->json(['message' => 'Enter is closed'], 403);
        }

        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
            'priority' => 'nullable|string',
            'due_date' => 'nullable|date',
            'assignee_id' => 'nullable|exists:users,id',
        ]);

        $task->update($data);

        return response()->json($task);
    }

    public function destroy(Task $task, Request $request)
    {
        $user = $request->user();
        $project = $task->project;

        if ($task->author_id !== $user->id && $project->owner_id !== $user->id) {
            return response()->json(['message' => 'Enter is closed'], 403);
        }

        $task->delete();

        return response()->json(['message' => 'Task was deleted']);
    }

    public function filter(Request $request)
    {
        $user = $request->user();

        $query = Task::query();

        if ($request->has('project_id')) {
            $projectId = $request->project_id;
            $project = \App\Models\Project::findOrFail($projectId);

            if ($project->owner_id !== $user->id && !$project->users->contains($user->id)) {
                return response()->json(['message' => 'Enter is close'], 403);
            }

            $query->where('project_id', $projectId);
        } else {
            $query->whereHas('project', function($q) use ($user) {
                $q->where('owner_id', $user->id)
                    ->orWhereHas('users', fn($q2) => $q2->where('user_id', $user->id));
            });
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('assignee_id')) {
            $query->where('assignee_id', $request->assignee_id);
        }

        $tasks = $query->get();

        return response()->json($tasks);
    }
}
