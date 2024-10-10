<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //  GET /api/books
    public function index()
    {
        //
        return response()->json(Book::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */

    //  POST /api/books
    public function store(Request $request)
    {
        //
        $request->validate([
            'title' => 'required|string',
            'image' => 'string|nullable',
            'price' => 'required|numeric'
        ]);

        $book = Book::create($request->all());

        return response()->json([
            'message' => 'Book added successfully',
            $book, 201]);
    }

    /**
     * Display the specified resource.
     */

    //  GET /api/books/{id}
    public function show($id)
    {
        //
        $book = Book::find($id);

        if(!$book){
            return response()->json([
                'message' => 'Book not found'
            ]);
        }
      
        return response()->json($book, 200);

    }

    /**
     * Update the specified resource in storage.
     */

    //  PUT /api/books/{id}
    public function update(Request $request, $id)
    {
        //
        $book = Book::find($id);

        if(!$book){
          return response()->json([
            'message' => 'Book not found'
          ]);
        }

        $request->validate([
            'title' => 'string',
            'image' => 'string|nullable',
            'price' => 'numeric'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */

    //  DELETE /api/books/{id}
    public function destroy($id)
    {
        //
        $book = Book::find($id);

        if(!$book){
            return response()->json([
                'message' => 'Book not found'
            ]);
        }
    }

    public function getBooksByGenre(Request $request)
    {
        $genre = $request->query('genre');

        // Fetch books by genre; if no genre is provided, fetch all books
        $books = $genre ? Book::where('genre', $genre)->get() : Book::all();

        return response()->json($books);
    }
}