<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WorkspaceController extends Controller
{
    public function index()
    {
        $workspaces = auth()->user()->workspaces;
        return view('workspaces.index', compact('workspaces'));
    }

    public function create()
    {
        return view('workspaces.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $workspace = Workspace::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name . '-' . uniqid()),
            'owner_id' => auth()->id(),
        ]);

        $workspace->users()->attach(auth()->id(), ['role' => 'owner']);

        session(['workspace_id' => $workspace->id]);

        return redirect()->route('dashboard')->with('success', 'Workspace created!');
    }

    public function show(Workspace $workspace)
    {
        $this->authorize('view', $workspace);
        return view('workspaces.show', compact('workspace'));
    }

    public function edit(Workspace $workspace)
    {
        $this->authorize('update', $workspace);
        return view('workspaces.edit', compact('workspace'));
    }

    public function update(Request $request, Workspace $workspace)
    {
        $this->authorize('update', $workspace);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $workspace->update($request->only('name'));

        return redirect()->route('dashboard')->with('success', 'Workspace updated!');
    }

    public function destroy(Workspace $workspace)
    {
        $this->authorize('delete', $workspace);
        $workspace->delete();
        session()->forget('workspace_id');
        return redirect()->route('dashboard')->with('success', 'Workspace deleted!');
    }

    public function switch(Workspace $workspace)
    {
        $this->authorize('view', $workspace);
        session(['workspace_id' => $workspace->id]);
        return redirect()->route('dashboard');
    }

    public function addMember(Request $request, Workspace $workspace)
    {
        $this->authorize('invite', $workspace);

        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'User not found');
        }

        if ($workspace->users()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'User already in workspace');
        }

        $workspace->users()->attach($user->id, ['role' => 'member']);

        return back()->with('success', 'Member added!');
    }
}