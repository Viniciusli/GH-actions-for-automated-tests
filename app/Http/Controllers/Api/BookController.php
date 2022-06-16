<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(): JsonResponse
    {
        // $books = Book::all()->paginate(10);

        return response()->json([
            'books' => $books
        ], 302);
    }

    public function store(StoreBookRequest $request): JsonResponse
    {
        $book = Book::create($request->validated());

        return response()->json([
            'message' => 'Book created successfully',
            'book' => $book
        ], 201);
    }

    public function update(UpdateBookRequest $request, Book $book): JsonResponse
    {
        if ($book->update($request->validated())) {
            return response()->json([
                'message' => 'Book updated successfully',
                'book' => $book
            ], 200);
        }

        return response()->json([
            'message' => 'Book not updated'
        ], 400);
    }

    public function destroy(Book $book): JsonResponse
    {
        if ($book->delete()) {
            return response()->json([
                'message' => 'Book deleted successfully'
            ], 200);
        }

        return response()->json([
            'message' => 'Book not deleted'
        ], 400);
    }
}
