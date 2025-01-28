<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function index(Project $project)
    {
        $this->authorize('view', $project);

        $tasks = $project->tasks()->latest()->get();

        return Inertia::render('Projects/Show', [
            'project' => $project,
            'tasks' => $tasks,
        ]);
    }

    public function store(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string', 'in:not_started,in_progress,completed'],
            'priority' => ['required', 'string', 'in:low,medium,high'],
            'completion_date' => ['nullable', 'date'],
        ]);

        $project->tasks()->create($validated);

        return redirect()->route('projects.show', $project);
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task->project);

        return Inertia::render('Projects/Show', [
            'project' => $task->project,
            'selectedTask' => $task,
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task->project);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string', 'in:not_started,in_progress,completed'],
            'priority' => ['required', 'string', 'in:low,medium,high'],
            'completion_date' => ['nullable', 'date'],
            'assigned_user_id' => ['nullable', 'integer'],
        ]);

        if ($validated['status'] === 'completed' && ! $task->completion_date) {
            $validated['completion_date'] = now();
        }

        $task->update($validated);

        return redirect()->route('projects.show', $task->project);
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task->project);

        $project = $task->project;
        $task->delete();

        return redirect()->route('projects.show', $project);
    }
}
