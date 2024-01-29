<?php

namespace App\Services;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Traits\AuthUserTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * TaskService
 */
class TaskService
{
    use AuthUserTrait;

    /**
     * @param Task $model
     */
    public function __construct(private readonly Task $model)
    {}

    /**
     * @param $request
     * @return JsonResponse
     */
    public function createTaskService($request): JsonResponse
    {
        try {
            $task = $this->model->create([
                'user_id' => $this->getAuthUser()->id,
                'title' => $request->title,
                'description' => $request->description
            ]);
            return response()->json([
                'message' => 'Task created successfully',
                'data' => new TaskResource($task),
                'success' => true
            ], Response::HTTP_CREATED);
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Error unable to create task',
                'error' => $e->getMessage(),
                'success'  => true
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getAllTaskService(): AnonymousResourceCollection
    {
        $tasks = $this->model->whereUserId($this->getAuthUser()->id)->latest()->paginate(10);
        return TaskResource::collection($tasks)->additional([
            'message' => "All task fetched successfully",
            'success' => true
        ], Response::HTTP_OK);
    }

    /**
     * @param $slug
     * @return TaskResource
     */
    public function getSingleTaskService($slug): TaskResource
    {
        $task = $this->model->whereSlug($slug)->whereUserId($this->getAuthUser()->id)->firstOrFail();
        return (new TaskResource($task))->additional( [
            'message' => "Task details fetched successfully",
            'success' => true
        ], Response::HTTP_OK);
    }

    /**
     * @param $request
     * @param $slug
     * @return JsonResponse
     */
    public function updateTaskService($request, $slug): JsonResponse
    {
        $task = $this->model->whereSlug($slug)->whereUserId($this->getAuthUser()->id)->firstOrFail();
        try {
            $task->update([
                'title' => empty($request->title) ? $task->title : $request->title,
                'description' => empty($request->description) ? $task->description : $request->description
            ]);
            return response()->json([
                'message' => 'Task update successfully',
                'data' => new TaskResource($task),
                'success' => true
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error unable to create task',
                'error' => $e->getMessage(),
                'success'  => true
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param $slug
     * @return JsonResponse
     */
    public function deleteTaskService($slug): JsonResponse
    {
        $task = $this->model->whereSlug($slug)->whereUserId($this->getAuthUser()->id)->firstOrFail();
        try {
            $task->delete();
            return response()->json([
                'message' => 'Task deleted successfully',
                'data' => new TaskResource($task),
                'success' => true
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error unable to delete task',
                'error' => $e->getMessage(),
                'success'  => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
