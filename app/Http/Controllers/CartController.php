<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //  GET /api/carts// GET /api/carts
public function index()
{
    // Get the authenticated user's ID
    $userId = auth()->id();

    // Retrieve the cart(s) for the authenticated user
    $carts = Cart::with('books')->where('user_id', $userId)->get();

    return response()->json($carts, 200);
}

    /**
     * Store a newly created resource in storage.
     */
 
    

     public function addToCart(Request $request)
     {
         // Validate the incoming request data
         $validated = $request->validate([
            'user_id'=>'required',
             'book_id' => 'required|integer|exists:books,id',
             'quantity' => 'required|integer|min:1',
         ]);
     
        
    // Get the authenticated user's ID
    $userId = auth()->id();


         // Find or create the cart for the user
         $cart = Cart::firstOrCreate(['user_id' => $userId]);
     
         // Check if the book already exists in the cart
         $existingBook = $cart->books()->where('book_id', $validated['book_id'])->first();
     
         if ($existingBook) {
             // If the book exists, update the quantity
             $cart->books()->updateExistingPivot($validated['book_id'], [
                 'quantity' => $existingBook->pivot->quantity + $validated['quantity']
             ]);
         } else {
             // If the book doesn't exist, add it to the cart with the specified quantity
             $cart->books()->attach($validated['book_id'], ['quantity' => $validated['quantity']]);
         }
     
         return response()->json(['message' => 'Book added to cart successfully'], 200);
     }
     
    
    
    /**
     * Display the specified resource.
     */

    //  GET /api/carts/{id}
    public function show($id)
    {
        //
        $cart = Cart::with('books')->find($id);

        if(!$cart){
            return response()->json([
                'mesage' => 'Cart not found'
            ]);
        }

        return response()->json($cart, 200);
    }

    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request, string $id)
    {
        //
        $cart = Cart::find($id);

        if(!$cart){
            return response()->json([
                'message' => 'Cart not found'
            ]);
        }

        $request->validate([
            'user_id' => 'exists:users,id',
            'book_id' => 'exists:books,id'
        ]);
    }
    public function removeFromCart(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'book_id' => 'required|integer|exists:books,id',
        ]);
    
        // Get the authenticated user's ID
        $userId = auth()->id();
    
        // Find the cart for the authenticated user
        $cart = Cart::where('user_id', $userId)->first();
    
        // If the cart doesn't exist, return an error
        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }
    
        // Check if the book exists in the cart
        if ($cart->books()->where('book_id', $validated['book_id'])->exists()) {
            // Remove the book from the cart
            $cart->books()->detach($validated['book_id']);
    
            return response()->json(['message' => 'Book removed from cart successfully'], 200);
        } else {
            return response()->json(['message' => 'Book not found in cart'], 404);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cart = Cart::find($id);

        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        $cart->delete();

        return response()->json(['message' => 'Cart deleted successfully'], 200);
    }
 }