<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TasksResource;
use App\Models\Task;
use App\Services\TaskService;
use App\Traits\HttpResponses;
use Exception;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    use HttpResponses;

    /**
     * Create Task Controller
     *
     * @param App\Service\TaskService $service
     */
    public function __construct(
        private TaskService $service
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if ($this->service) {

                return HttpResponses::success(
                    $this->service->all(),
                    'Total list of task based on user.'
                );
            } else {

                return HttpResponses::serverFailed(
                    '',
                    ''
                );
            }
        } catch (Exception $e) {

            return HttpResponses::error(
                '',
                'Cannot run fetching' . $e,
                500
            );
        } catch (ServerException $se) {
            return HttpResponses::serverFailed(
                '',
                ''
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $storeRequest)
    {
        $storeRequest->validated($storeRequest->all());

        $task = Task::create([
            'user_id' => Auth::user()->id,
            'name' => $storeRequest->name,
            'description' => $storeRequest->description,
            'priority' => $storeRequest->priority
        ]);

        return new TasksResource($task);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return $this->isNotAuthorized($task)
            ? $this->isNotAuthorized($task)
            : new TasksResource($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        if (Auth::user()->id !== $task->user_id) {
            return $this->error(
                '',
                'You are not authorized to make this request',
                403
            );
        }
        $task->update($request->all());

        return new TasksResource($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //Directly pass delte method We will not send task resource
        return $this->isNotAuthorized($task)
            ? $this->isNotAuthorized($task)
            : $task->delete();
    }

    private function isNotAuthorized(Task $task)
    {
        if (Auth::user()->id !== $task->user_id) {
            return $this->error(
                '',
                'You are not authorized to make this request',
                403
            );
        }
    }
}
