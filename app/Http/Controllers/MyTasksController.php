<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyTasksController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');

        $query = auth()->user()->assignedTasks()->with(['project.workspace', 'assignee']);

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $tasks = $query->orderBy('due_date')->paginate(20);

        return view('my-tasks', compact('tasks', 'status', 'search'));
    }
}