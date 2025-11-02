<?php

use App\Http\Controllers\MyTasksController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WorkspaceController;
use App\Models\Project;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        $workspace = null;
        if (session('workspace_id')) {
            $workspace = auth()->user()->workspaces()->with('activities')->find(session('workspace_id'));
        }
        if (!$workspace) {
            $workspace = auth()->user()->workspaces()->with('activities')->first();
            if ($workspace) {
                session(['workspace_id' => $workspace->id]);
            }
        }
        return view('dashboard', compact('workspace'));
    })->name('dashboard');

    // Workspaces
    Route::resource('workspaces', WorkspaceController::class);
    Route::post('workspaces/{workspace}/switch', [WorkspaceController::class, 'switch'])->name('workspaces.switch');
    Route::post('workspaces/{workspace}/add-member', [WorkspaceController::class, 'addMember'])->name('workspaces.addMember');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Projects
    Route::resource('projects', ProjectController::class);
    Route::get('projects/{project}/kanban', function(Project $project) {
        return view('projects.kanban', compact('project'));
    })->name('projects.kanban');

    // Tasks
    Route::resource('tasks', TaskController::class);
    Route::patch('tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');

    // My tasks
    Route::get('/my-tasks', [MyTasksController::class, 'index'])->name('my-tasks');
});

require __DIR__.'/auth.php';