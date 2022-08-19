<?php

namespace Http\Controllers;

use Enums\TaskStatusEnum;
use Exceptions\CustomException;
use Http\Requests\TaskStoreRequest;
use Http\Requests\TaskUpdateRequest;
use Http\Resources\BasicResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Notifications\TaskClosed;
use Task;
use function __;
use function response;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $tasks = Auth::user()->tasks;
        return response(new BasicResource(['data' => $tasks]), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TaskStoreRequest $request
     * @return Response
     */
    public function store(TaskStoreRequest $request): Response
    {
        $task = Task::create($request->all());
        return response(new BasicResource(['data' => $task, 'message' => __('messages.successfulStore')]), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Task $task
     * @return Response
     */
    public function show(Task $task): Response
    {
        if (Auth::user()->can('view', $task)) {
            return response(new BasicResource(['data' => $task]), 200);
        }
        throw new CustomException(__('messages.AuthorizationException'),401);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Task $task
     * @return Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TaskUpdateRequest $request
     * @param Task $task
     * @return Response
     */
    public function update(TaskUpdateRequest $request, Task $task): Response
    {
        if (Auth::user()->can('view', $task)) {
            DB::transaction(function () use ($task, $request) {
                if ($request->has('labels')) {
                    $task->labels()->sync($request->input('labels'));
                }
                $task->update($request->all());
                if ($request->has('status') and $request->input('status') == TaskStatusEnum::CLOSE) {
                    $message = 'task: ' . $task->title . ' is closed by you';
                    Log::notice($message);
                    $request->user()->notify(new TaskClosed($message));
                }
            });
            return response(new BasicResource(['data' => $task, 'message' => __('messages.successfulUpdate')]), 200);
        }
        throw new CustomException(__('messages.AuthorizationException'),401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
