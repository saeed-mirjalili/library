<?php

namespace Tests\Feature;

use App\Models\user\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddBooksTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_add_books_without_authenticate(): void
    {
        $response = $this->post('/api/panel/add');

        $response->assertStatus(401);
        $response->assertJsonStructure(['message']);
    }
    public function test_add_books_without_authorize(): void
    {
        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => 'password'
        ]);
        $response = $this->actingAs($user)->post('/api/permissions',[
            'books[0]'=>0,
            'books[1]'=>1,
            'books[2]'=>2,
        ]);

        $response->assertStatus(403);
        $response->assertJsonStructure(['error']);
    }
    public function test_add_books_invalid_data(): void
    {
        $user = User::whereName('AdminUser')->first();
        $response = $this->actingAs($user)->post('/api/permissions',[
            'books[0]'=>'a',
            'books[1]'=>'b',
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['error']);
    }
}
