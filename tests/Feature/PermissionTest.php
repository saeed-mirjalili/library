<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\user\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_create_permission_without_authenticate(): void
    {
        $response = $this->post('/api/permissions');

        $response->assertStatus(401);
        $response->assertJsonStructure(['message']);
    }
    public function test_create_permission_without_authorize(): void
    {
        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => 'password'
        ]);
        $response = $this->actingAs($user)->post('/api/permissions',[
            'name'=>'ff',
            'display_name'=>'jj'
        ]);

        $response->assertStatus(403);
        $response->assertJsonStructure(['error']);
    }
}
