<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_login_to_application_is_successful()
    {
        $user = User::factory()->create();
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @return void
     */
    public function test_login_to_application_failed()
    {
        $user = User::factory()->create();
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'Password@123'
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertExactJson([
            'message' => 'Invalid login details',
            'success' => false
        ]);
    }

    /**
     * @return void
     */
    public function test_check_user_profile_successful()
    {
        $user = User::factory()->create();
        $token = \JWTAuth::fromUser($user);
        $response = $this->getJson('/api/v1/auth/profiles?token='.$token);
        $response->assertStatus(Response::HTTP_OK)->assertJsonStructure([
            'data', 'message', 'success'
        ]);
    }

    /**
     * @return void
     */
    public function test_logout_route_successful()
    {
        $user = User::factory()->create();
        $token = \JWTAuth::fromUser($user);
        $response = $this->postJson('/api/v1/auth/logout?token='.$token);
        $response->assertStatus(Response::HTTP_OK)->assertExactJson([
            'message' => 'Logged out successfully',
            'success' => true
        ]);
    }

    /**
     * @return void
     */
    public function test_refresh_token_successful()
    {
        $user = User::factory()->create();
        $token = \JWTAuth::fromUser($user);
        $response = $this->postJson('/api/v1/auth/refresh?token='.$token);
        $response->assertStatus(Response::HTTP_OK);
    }

}
