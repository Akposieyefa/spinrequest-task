<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_can_create_task_successfully()
    {
        $user = User::factory()->create();
        $token = \JWTAuth::fromUser($user);
        $response = $this->postJson('/api/v1/tasks/create?token=' . $token, [
            'title' => fake()->title,
            'description' => fake()->sentence
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * @return void
     */
    public function test_can_get_all_tasks_successfully()
    {
        $user = User::factory()->create();
        $token = \JWTAuth::fromUser($user);
        $response = $this->getJson('/api/v1/tasks/all?token=' . $token);
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @return void
     */
    public function test_can_view_single_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();
        $token = \JWTAuth::fromUser($user);
        $response = $this->getJson('/api/v1/tasks/single/'. $task->slug .'?token=' . $token);
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @return void
     */
    public function test_can_update_task_successfully()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();
        $token = \JWTAuth::fromUser($user);
        $response = $this->patchJson('/api/v1/tasks/update/'. $task->slug .'?token=' . $token, [
            'title' => fake()->title,
            'description' => fake()->sentence
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @return void
     */
    public function test_can_delete_task_successfully()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();
        $token = \JWTAuth::fromUser($user);
        $response = $this->deleteJson('/api/v1/tasks/delete/'. $task->slug .'?token=' . $token);
        $response->assertStatus(Response::HTTP_OK);
    }
}
