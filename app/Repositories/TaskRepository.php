<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskRepository
{
    public function getAllTasks()
    {
        return Task::where('user_id', Auth::id())->get();
    }

    public function getTaskById(string $id)
    {
        return Task::where('user_id', Auth::id())->findOrFail($id);
    }

    public function createTask(array $data)
    {
        $data['user_id'] = Auth::id();
        return Task::create($data);
    }

    public function updateTask(string $id, array $data)
    {
        $task = $this->getTaskById($id);
        $task->update($data);
        return $task;
    }

    public function deleteTask(string $id)
    {
        $task = $this->getTaskById($id);
        return $task->delete();
    }
}