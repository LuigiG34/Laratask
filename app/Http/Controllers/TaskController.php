<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $projectId = $request->query('project_id');
        $status = $request->query('status');

        if (!$projectId) {
            return redirect()->route('projects.index');
        }

        $project = Project::findOrFail($projectId);
        $this->authorize('view', $project);

        $query = $project->tasks()->with('assignee');

        if ($status) {
            $query->where('status', $status);
        }

        $tasks = $query->orderBy('position')->get();

        return view('tasks.index', compact('project', 'tasks'));
    }

    public function create(Request $request)
    {
        $projectId = $request->query('project_id');
        
        if (!$projectId) {
            return redirect()->route('projects.index');
        }

        $project = Project::findOrFail($projectId);
        $this->authorize('view', $project);

        $members = $project->workspace->users;

        return view('tasks.create', compact('project', 'members'));
    }

    public function store(Request $request)
    {
        $project = Project::findOrFail($request->project_id);
        $this->authorize('view', $project);

        $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:todo,in_progress,done'],
            'due_date' => ['nullable', 'date'],
            'assigned_to' => ['nullable', 'exists:users,id'],
        ]);

        $task = $project->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'due_date' => $request->due_date,
            'assigned_to' => $request->assigned_to,
            'position' => $project->tasks()->max('position') + 1,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'task' => $task]);
        }

        return redirect()->route('projects.show', $project)->with('success', 'Task created!');
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);
        
        $task->load(['assignee', 'comments.user']);
        $members = $task->project->workspace->users;

        return view('tasks.show', compact('task', 'members'));
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        
        $members = $task->project->workspace->users;

        return view('tasks.edit', compact('task', 'members'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:todo,in_progress,done'],
            'due_date' => ['nullable', 'date'],
            'assigned_to' => ['nullable', 'exists:users,id'],
        ]);

        $task->update($request->only(['title', 'description', 'status', 'due_date', 'assigned_to']));

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('tasks.show', $task)->with('success', 'Task updated!');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        
        $projectId = $task->project_id;
        $task->delete();

        return redirect()->route('projects.show', $projectId)->with('success', 'Task deleted!');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'status' => ['required', 'in:todo,in_progress,done'],
        ]);

        $task->update(['status' => $request->status]);

        return response()->json(['success' => true]);
    }
}