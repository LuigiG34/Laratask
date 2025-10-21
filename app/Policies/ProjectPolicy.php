<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // User can view projects in their workspaces
    }

    public function view(User $user, Project $project): bool
    {
        // Check if user has access to the workspace
        return $project->workspace->users()->where('user_id', $user->id)->exists();
    }

    public function create(User $user): bool
    {
        return true; // All users can create projects in their workspaces
    }

    public function update(User $user, Project $project): bool
    {
        // Can update if user is in the workspace
        return $project->workspace->users()->where('user_id', $user->id)->exists();
    }

    public function delete(User $user, Project $project): bool
    {
        // Only workspace owner or admins can delete
        $workspace = $project->workspace;
        return $workspace->owner_id === $user->id || 
               $workspace->users()->where('user_id', $user->id)->wherePivot('role', 'admin')->exists();
    }
}