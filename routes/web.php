<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WorkspaceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        $workspace = null;
        if (session('workspace_id')) {
            $workspace = auth()->user()->workspaces()->find(session('workspace_id'));
        }
        if (!$workspace) {
            $workspace = auth()->user()->workspaces()->first();
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

    // Tasks
    Route::resource('tasks', TaskController::class);
    Route::patch('tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
});

require __DIR__.'/auth.php';