<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Activity;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'title', 'description', 'status', 'due_date', 'assigned_to', 'position'];

    protected $casts = [
        'due_date' => 'date',
    ];


    // ------------------------------ RELATIONSHIPS ------------------------------
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
    // ------------------------------ RELATIONSHIPS ------------------------------


    protected static function boot()
    {
        parent::boot();

        static::created(function ($task) {
            Activity::create([
                'workspace_id' => $task->project->workspace_id,
                'user_id' => auth()->id(),
                'type' => 'task_created',
                'description' => auth()->user()->name . ' created task "' . $task->title . '"',
                'subject_id' => $task->id,
                'subject_type' => Task::class,
            ]);
        });

        static::updated(function ($task) {
            if ($task->isDirty('status')) {
                $oldStatus = $task->getOriginal('status');
                $newStatus = $task->status;
                
                Activity::create([
                    'workspace_id' => $task->project->workspace_id,
                    'user_id' => auth()->id(),
                    'type' => 'task_status_changed',
                    'description' => auth()->user()->name . ' moved task "' . $task->title . '" from ' . ucfirst($oldStatus) . ' to ' . ucfirst($newStatus),
                    'subject_id' => $task->id,
                    'subject_type' => Task::class,
                ]);
            }
        });
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}