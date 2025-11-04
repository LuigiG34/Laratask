<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Workspace;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $workspaceId = session('workspace_id');
        
        if (!$workspaceId) {
            return redirect()->route('dashboard')->with('error', 'Please select a workspace');
        }

        $workspace = Workspace::findOrFail($workspaceId);
        $this->authorize('view', $workspace);

        $projects = $workspace->projects()->withCount('tasks')->get();

        return view('projects.index', compact('workspace', 'projects'));
    }

    public function create()
    {
        $workspaceId = session('workspace_id');
        
        if (!$workspaceId) {
            return redirect()->route('dashboard')->with('error', 'Please select a workspace');
        }

        $workspace = Workspace::findOrFail($workspaceId);
        $this->authorize('view', $workspace);

        return view('projects.create', compact('workspace'));
    }

    public function store(Request $request)
    {
        $workspaceId = session('workspace_id');
        
        if (!$workspaceId) {
            return redirect()->route('dashboard')->with('error', 'Please select a workspace');
        }

        $workspace = Workspace::findOrFail($workspaceId);
        $this->authorize('view', $workspace);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'color' => ['required', 'string'],
        ]);

        $project = $workspace->projects()->create([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color,
        ]);

        return redirect()->route('projects.show', $project)->with('success', 'Project created!');
    }

    public function show(Request $request, Project $project)
    {
        $this->authorize('view', $project);

        $query = $project->tasks()->with('assignee');

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $project->load(['tasks' => function($q) use ($query) {
            $q->mergeConstraintsFrom($query)->orderBy('position');
        }]);

        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'color' => ['required', 'string'],
        ]);

        $project->update($request->only(['name', 'description', 'color']));

        return redirect()->route('projects.show', $project)->with('success', 'Project updated!');
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted!');
    }
}