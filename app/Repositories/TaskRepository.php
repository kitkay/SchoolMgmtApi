<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class TaskRepository
{
    public function __construct(private Task $task)
    {
    }

    public function all(): Collection
    {
        return $this->task::where(
            'user_id',
            Auth::user()->id
        )->get();
    }
}