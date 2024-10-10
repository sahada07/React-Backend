<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id('book_id');
            $table->string('title',100);
            $table->string('author',400);
            $table->string('isbn',20);
            $table->float('price');
            $table->string('description');
            $table->string('publication_data',300);
            $table->string('genre');
            $table->string('category');
            $table->string('in_stock',1);
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
