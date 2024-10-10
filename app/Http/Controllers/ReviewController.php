<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // GET /api/reviews
    public function index()
    {
        //
        return response()->json(Review::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */

    //  POST /api/reviews
    public function store(Request $request)
    {
        //
        $review = Review::create(request()->all());

        return response()->json($review, 201);
    }

    /**
     * Display the specified resource.
     */

    //  GET /api/reviews/{id}
    public function show(string $id)
    {
        //
        $review = Review::find($id);

        if(!$review){
            return response()->json([
              'message' => 'Review not found!'
            ]);
        }

        return response()->json($review, 200);
    }

    /**
     * Update the specified resource in storage.
     */

    //  PUT /api/reviews/{id}
    public function update(Request $request, $id)
    {
        //
        $review = Review::find($id);

        if(!$review){
            return response()->json([
                'message' => 'Review not found'
            ]);
        }

        $request->validate([
            'comment' => 'string',
            'rating' => 'integer|min:1|max:5'
        ]);

        $review->update($request->all());

        return response()->json($review, 200);

    }

    /**
     * Remove the specified resource from storage.
     */

    //  DELETE /api/reviews/{id}
    public function destroy( $id)
    {
        //
        $review = Review::find($id);

        if(!$review){
           return response()->json([
            'message' => 'Review not found'
           ]);
        }

        $review->delete();

        return response()->json([
            'message' => 'Review deleted successfully'
        ]);
    }
}