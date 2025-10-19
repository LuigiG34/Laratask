<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Workspace;

class WorkspacePolicy
{
    public function viewAny(User $user): bool
    {
        return true; // All users can view their workspaces
    }

    public function view(User $user, Workspace $workspace): bool
    {
        return $workspace->users()->where('user_id', $user->id)->exists();
    }

    public function create(User $user): bool
    {
        return true; // All users can create workspaces
    }

    public function update(User $user, Workspace $workspace): bool
    {
        return $workspace->owner_id === $user->id || 
               $workspace->users()->where('user_id', $user->id)->wherePivot('role', 'admin')->exists();
    }

    public function delete(User $user, Workspace $workspace): bool
    {
        return $workspace->owner_id === $user->id;
    }

    public function invite(User $user, Workspace $workspace): bool
    {
        return $workspace->owner_id === $user->id || 
               $workspace->users()->where('user_id', $user->id)->wherePivot('role', 'admin')->exists();
    }
}