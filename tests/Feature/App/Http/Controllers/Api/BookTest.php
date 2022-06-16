<?php

namespace Tests\Feature\App\Http\Controllers\Api;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function testBooksCanBeListedForApi(): void
    {
        // prepare
        Book::factory()->create();

        // act
        $response = $this->get('/api/books');

        // assert
        $response->assertStatus(302);
    }

    public function testBookCanBeCreatedForApi(): void
    {
        // prepare
        $user = User::factory()->create();
        $payload = [
            'title' => 'title test',
            'author' => 'author test',
            'description' => 'description test',
            'published_at' => date('Y-m-d', strtotime('-1 year')),
        ];

        // act
        $this->post('api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response = $this->postJson('/api/books', $payload);

        // assert
        $response->assertStatus(201);
    }

    public function testBookCanBeUpdatedForApi(): void
    {
        // prepare
        $user = User::factory()->create();
        $payload = [
            'title' => 'title test',
            'author' => 'author test',
            'description' => 'description test',
            'published_at' => date('Y-m-d', strtotime('-1 year'))
        ];
        $book = Book::factory()->create($payload);

        // act
        $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response = $this->putJson("/api/books/{$book->id}", [
            'author' => 'author test updated'
        ]);

        // assert
        $response->assertStatus(200);
    }

    public function testUserCanBeDeletedForApi(): void
    {
        // prepare
        $user = User::factory()->create();
        $book = Book::factory()->create();

        // act
        $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response = $this->delete('/api/books/' . $book->id);

        // assert
        $response->assertStatus(200);
    }
}
