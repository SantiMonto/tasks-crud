<?php

namespace App\Livewire;

use Livewire\Component;
use App\Repositories\TaskRepository;

class Tasks extends Component
{
    public $tasks, $title, $description, $taskId;
    public $isEditing = false;
    protected $taskRepository;

    protected $rules = [
        'title' => 'required|string|max:100',
        'description' => 'nullable|string',
    ];

    public function boot(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function render()
    {
        $this->tasks = $this->taskRepository->getAllTasks();
        return view('livewire.tasks');
    }

    public function createTask()
    {
        $data = $this->validate();
        
        if (!$this->isEditing) {
            $data['status'] = false;
        }

        if ($this->isEditing) {
            $this->taskRepository->updateTask($this->taskId, $data);
            $this->isEditing = false;
        } else {
            $this->taskRepository->createTask($data);
        }

        $this->resetForm();
    }

    public function editTask($id)
    {
        $this->isEditing = true;
        $this->taskId = $id;
        $task = $this->taskRepository->getTaskById($id);
        
        $this->title = $task->title;
        $this->description = $task->description;
    }

    public function cancelEdit()
    {
        $this->isEditing = false;
        $this->resetForm();
    }

    public function deleteTask($id)
    {
        $this->taskRepository->deleteTask($id);
    }

    public function toggleStatus($id)
    {
        $task = $this->taskRepository->getTaskById($id);
        $this->taskRepository->updateTask($id, [
            'status' => !$task->status
        ]);
    }

    private function resetForm()
    {
        $this->reset(['title', 'description', 'taskId', 'isEditing']);
    }
}