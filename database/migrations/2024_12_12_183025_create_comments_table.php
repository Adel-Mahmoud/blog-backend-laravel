<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('post_id')
                  ->constrained('posts') // Assumes a 'posts' table exists
                  ->onUpdate('cascade')
                  ->onDelete('cascade'); // Foreign key with actions
            $table->string('username');
            $table->string('picture');
            $table->text('comment');
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
