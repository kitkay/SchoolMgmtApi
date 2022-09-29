<?php

namespace App\Services;

use App\Http\Resources\TasksResource;
use App\Repositories\TaskRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskService
{
    public function __construct(private TaskRepository $repository)
    {
    }

    public function all(): ResourceCollection
    {
        return TasksResource::collection(
            $this->repository->all()
        );
    }
}
