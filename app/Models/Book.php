<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'image', 'price', 'author_id'];

    // A book belongs to an author
    public function author(){
        return $this->belongsTo(Author::class);
    }
   
    // A book can belong to many carts
    public function carts(){
        return $this->belongsToMany(Cart::class, 'cart_book')->withPivot('quantity')->withTimestamps();
    }

    // A book can have many reviews
    public function reviews(){
        return $this->hasMany(Review::class);
    }
}