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
        $payload = [
            'title' => 'title test',
            'author' => 'author test',
            'decription' => 'description test',
            'published_at' => '2020-01-01'
        ];

        // act
        $response = $this->get('/api/books', $payload);

        // assert
        $response->assertStatus(201);
        $response->seeInDatabase('books', $payload);
    }

    public function testBookCanBeUpdatedForApi(): void
    {
        // prepare
        $payload = [
            'title' => 'title test',
            'author' => 'author test',
            'description' => 'description test',
            'published_at' => '2020-01-01'
        ];
        $book = Book::factory()->create($payload);

        // act
        $response = $this->put("/book/{$book->id}", [
            'author' => 'author test updated',
        ]);

        // assert
        $response->assertStatus(200);
        $response->seeInDatabse('books', [
            'author' => 'author test updated',
        ]);
    }

    public function testUserCanBeDeletedForApi(): void
    {
        // prepare
        $book = Book::factory()->create();

        // act
        $response = $this->delete('/api/books/' . $book);

        // assert
        $response->assertStatus(200);
    }
}
