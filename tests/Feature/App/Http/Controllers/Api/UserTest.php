<?php

namespace Tests\Feature\App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanBeCreated()
    {
        // prepare
        $payload = [
            'name' => 'Name teste',
            'email' => 'mailTest@test.com',
            'password' => '1234567',
            'password_confirmation' => '1234567'
        ];

        // act
        $response = $this->post('/api/register', $payload);

        // assert
        $response->assertStatus(201);
    }

    public function testUserCanBeLoggedIn()
    {
        // prepare
        $user = User::factory()->create();


        // act
        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        // assert
        $this->assertAuthenticated();
        $response->assertStatus(200);
    }
}
