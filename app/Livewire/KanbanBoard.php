<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\Task;
use Livewire\Component;

class KanbanBoard extends Component
{
    public $projectId;
    public $project;
    public $newTaskTitle = '';
    public $newTaskColumn = '';

    public function mount($projectId)
    {
        $this->projectId = $projectId;
        $this->project = Project::with(['tasks' => function($query) {
            $query->with('assignee')->orderBy('position');
        }])->findOrFail($projectId);
    }

    public function render()
    {
        $todoTasks = $this->project->tasks->where('status', 'todo');
        $inProgressTasks = $this->project->tasks->where('status', 'in_progress');
        $doneTasks = $this->project->tasks->where('status', 'done');

        return view('livewire.kanban-board', [
            'todoTasks' => $todoTasks,
            'inProgressTasks' => $inProgressTasks,
            'doneTasks' => $doneTasks,
        ]);
    }

    public function updateTaskOrder($taskId, $newStatus, $newPosition)
    {
        $task = Task::findOrFail($taskId);
        
        // Check authorization
        if (!$task->project->workspace->users()->where('user_id', auth()->id())->exists()) {
            return;
        }

        // Update task status and position
        $task->update([
            'status' => $newStatus,
            'position' => $newPosition,
        ]);

        // Refresh the project
        $this->mount($this->projectId);
    }

    public function addTask()
    {
        $this->validate([
            'newTaskTitle' => 'required|string|max:255',
            'newTaskColumn' => 'required|in:todo,in_progress,done',
        ]);

        $maxPosition = $this->project->tasks()->where('status', $this->newTaskColumn)->max('position') ?? 0;

        $this->project->tasks()->create([
            'title' => $this->newTaskTitle,
            'status' => $this->newTaskColumn,
            'position' => $maxPosition + 1,
        ]);

        $this->newTaskTitle = '';
        $this->newTaskColumn = '';
        
        // Refresh
        $this->mount($this->projectId);
    }
}