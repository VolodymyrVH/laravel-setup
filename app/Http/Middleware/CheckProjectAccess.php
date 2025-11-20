<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Project;

class CheckProjectAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        $projectId = $request->route('project') ?? $request->route('task')->project_id ?? null;

        if (!$projectId) {
            return response()->json(['message' => 'Project not selected'], 400);
        }

        $project = Project::find($projectId);

        if (!$project) {
            return response()->json(['message' => 'Project cant find'], 404);
        }

        // Перевірка доступу: власник або учасник
        if ($project->owner_id !== $user->id && !$project->users->contains($user->id)) {
            return response()->json(['message' => 'Enter is closed'], 403);
        }

        // Додаємо проект у запит для контролера (опційно)
        $request->merge(['project_model' => $project]);

        return $next($request);
    }
}
