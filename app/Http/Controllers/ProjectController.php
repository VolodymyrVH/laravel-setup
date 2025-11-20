<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $projects = Project::where('owner_id', $user->id)
            ->orWhereHas('users', fn($q) => $q->where('user_id', $user->id))
            ->get();
        return response()->json($projects);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $project = Project::create([
            'name' => $data['name'],
            'owner_id' => $request->user()->id
        ]);

        return response()->json($project, 201);
    }

    public function show($id, Request $request)
    {
        $project = Project::findOrFail($id);

        if ($project->owner_id !== $request->user()->id && !$project->users->contains($request->user()->id)) {
            return response()->json(['message' => 'Enter is closed'], 403);
        }

        return response()->json($project);
    }

    public function update($id, Request $request)
    {
        $project = Project::findOrFail($id);

        if ($project->owner_id !== $request->user()->id) {
            return response()->json(['message' => 'Enter is closed'], 403);
        }

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
        ]);

        $project->update($data);

        return response()->json($project);
    }

    public function destroy($id, Request $request)
    {
        $project = Project::findOrFail($id);

        if ($project->owner_id !== $request->user()->id) {
            return response()->json(['message' => 'Enter is closed'], 403);
        }

        $project->delete();

        return response()->json(['message' => 'project deleted']);
    }
}
