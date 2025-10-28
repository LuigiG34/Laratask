<?php

namespace App\Livewire;

use App\Models\Activity;
use App\Models\Comment;
use App\Models\Task;
use Livewire\Component;

class TaskComments extends Component
{
    public $taskId;
    public $task;
    public $newComment = '';
    public $editingCommentId = null;
    public $editingCommentBody = '';

    public function mount($taskId)
    {
        $this->taskId = $taskId;
        $this->task = Task::with(['comments.user'])->findOrFail($taskId);
    }

    public function render()
    {
        $this->task = Task::with(['comments.user'])->findOrFail($this->taskId);
        return view('livewire.task-comments');
    }

    public function addComment()
    {
        $this->validate([
            'newComment' => 'required|string|max:1000',
        ]);

        $comment = $this->task->comments()->create([
            'user_id' => auth()->id(),
            'body' => $this->newComment,
        ]);

        // Log activity
        Activity::create([
            'workspace_id' => $this->task->project->workspace_id,
            'user_id' => auth()->id(),
            'type' => 'comment_added',
            'description' => auth()->user()->name . ' commented on "' . $this->task->title . '"',
            'subject_id' => $comment->id,
            'subject_type' => Comment::class,
        ]);

        $this->newComment = '';
        $this->dispatch('comment-added');
    }

    public function editComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        
        if ($comment->user_id !== auth()->id()) {
            return;
        }

        $this->editingCommentId = $commentId;
        $this->editingCommentBody = $comment->body;
    }

    public function updateComment()
    {
        $this->validate([
            'editingCommentBody' => 'required|string|max:1000',
        ]);

        $comment = Comment::findOrFail($this->editingCommentId);
        
        if ($comment->user_id !== auth()->id()) {
            return;
        }

        $comment->update(['body' => $this->editingCommentBody]);

        $this->editingCommentId = null;
        $this->editingCommentBody = '';
    }

    public function cancelEdit()
    {
        $this->editingCommentId = null;
        $this->editingCommentBody = '';
    }

    public function deleteComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        
        if ($comment->user_id !== auth()->id()) {
            return;
        }

        $comment->delete();
    }
}