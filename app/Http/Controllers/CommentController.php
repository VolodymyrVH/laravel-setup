<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index(Task $task, Request $request)
    {
        $user = $request->user();
        $project = $task->project;

        if ($project->owner_id !== $user->id && !$project->users->contains($user->id)) {
            return response()->json(['message' => 'Enter is closed'], 403);
        }

        $comments = $task->comments()->with('author')->get();
        return response()->json($comments);
    }

    public function store(Task $task, Request $request)
    {
        $user = $request->user();
        $project = $task->project;

        if ($project->owner_id !== $user->id && !$project->users->contains($user->id)) {
            return response()->json(['message' => 'Enter is closed'], 403);
        }

        $data = $request->validate([
            'body' => 'required|string',
        ]);

        $comment = Comment::create([
            'task_id' => $task->id,
            'author_id' => $user->id,
            'body' => $data['body'],
        ]);

        return response()->json($comment, 201);
    }

    public function destroy(Comment $comment, Request $request)
    {
        $user = $request->user();

        if ($comment->author_id !== $user->id) {
            return response()->json(['message' => 'Enter is closed'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment was deleted']);
    }
}
