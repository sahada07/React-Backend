<?php

namespace App\Http\Controllers;


use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //  GET /api/authors
    public function index()
    {
        //
        return response()->json(Author::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */

    //  POST /api/authors
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string',
            'gender' => 'required|in:male,female',
            'dob' => 'required'
        ]);

        $author = Author::create($request->all());

        return response()->json([
            'message' => 'Author added successfully',
            $author, 201]);
    }

    /**
     * Display the specified resource.
     */

    //  GET /api/authors
    public function show($id)
    {
        //
        $author = Author::find($id);

        if(!$author){
            return response()->json([
                'message'=> 'Author not found'
            ]);
        }

        return response()->json($author, 200);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $author = Author::find($id);

        if(!$author){
            return response()->json([
                'message' => 'Author not found'
            ]);
        }

        $request->validate([
            'name' => 'string',
            'gender' => 'in:male,female',
            'dob' => 'date'
        ]);

        $author->update($request->all());

        return response()->json([
            'message' => 'Author updated successfully',
            $author, 201]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $author = Author::find($id);

        if(!$author){
            return response()->json([
                'message' => 'Author not found'
            ]);
        }

        $author->delete();
        return response()->json([
            'message' => 'Author deleted successfully',
            $author, 201]);
    }
}