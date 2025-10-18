<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create a test user
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
        ]);

        // Create another user for assigning tasks
        $user2 = User::factory()->create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
        ]);

        // Create a workspace owned by user
        $workspace = Workspace::factory()->create([
            'owner_id' => $user->id,
        ]);

        // Add both users to workspace
        $workspace->users()->attach($user->id, ['role' => 'owner']);
        $workspace->users()->attach($user2->id, ['role' => 'member']);

        // Create 3 projects
        $projects = Project::factory(3)->create([
            'workspace_id' => $workspace->id,
        ]);

        // Create tasks for each project
        foreach ($projects as $project) {
            $tasks = Task::factory(5)->create([
                'project_id' => $project->id,
                'assigned_to' => fake()->randomElement([$user->id, $user2->id, null]),
            ]);

            // Create comments on some tasks
            foreach ($tasks->random(2) as $task) {
                Comment::factory(2)->create([
                    'user_id' => fake()->randomElement([$user->id, $user2->id]),
                    'commentable_id' => $task->id,
                    'commentable_type' => Task::class,
                ]);
            }
        }
    }
}