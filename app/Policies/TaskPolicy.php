<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Task $task): bool
    {
        // Check if user has access to the project's workspace
        return $task->project->workspace->users()->where('user_id', $user->id)->exists();
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Task $task): bool
    {
        return $task->project->workspace->users()->where('user_id', $user->id)->exists();
    }

    public function delete(User $user, Task $task): bool
    {
        return $task->project->workspace->users()->where('user_id', $user->id)->exists();
    }
}