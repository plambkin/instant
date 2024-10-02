<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');  // Foreign key to users table
            $table->string('original_garden_image'); // Path to the original image
            $table->string('ai_generated_garden_image'); // Path to the AI-generated image
            $table->text('garden_design'); // Long text for garden design layout
            $table->json('garden_items');  // JSON field for list of items (flowers, statues, etc.)
            $table->timestamps(); // Creation date (automatically added with Laravel)
            
            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submissions');
    }
}

