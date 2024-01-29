<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;

/**
 * TaskController
 */
class TaskController extends Controller
{

    /**
     * @param TaskService $taskService
     */
    public function __construct(private readonly TaskService $taskService)
    {}

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return $this->taskService->getAllTaskService();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], 422);
        }else {
            return $this->taskService->createTaskService($request);
        }
    }

    /**
     * @param string $slug
     * @return TaskResource
     */
    public function show(string $slug): TaskResource
    {
        return $this->taskService->getSingleTaskService($slug);
    }

    /**
     * @param Request $request
     * @param string $slug
     * @return JsonResponse
     */
    public function update(Request $request, string $slug): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes',
            'description' => 'sometimes',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], 422);
        }else {
            return $this->taskService->updateTaskService($request, $slug);
        }
    }

    /**
     * @param string $slug
     * @return JsonResponse
     */
    public function destroy(string $slug): JsonResponse
    {
        return $this->taskService->deleteTaskService($slug);
    }

}
