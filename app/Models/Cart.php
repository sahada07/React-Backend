<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['user_id'];
//    protected $guarded = [];
    // A cart belongs to a user
    public function user(){
        return $this->belongsTo(User::class);
    }

    // A cart can have many books
    public function books(){
        return $this->belongsToMany(Book::class, 'cart_book')->withPivot('quantity')->withTimestamps();
    }
}