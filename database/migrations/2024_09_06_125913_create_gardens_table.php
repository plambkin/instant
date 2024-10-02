<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGardensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gardens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link to the users table
            $table->text('design_text')->nullable(); // Use TEXT type for large garden design text
            $table->text('cost_breakdown')->nullable(); // Use TEXT type for large cost breakdown text
            $table->string('photo_path')->nullable(); // Optional photo path for user-uploaded images
            $table->string('illustration1')->nullable(); // Store the first illustration URL
            $table->string('illustration2')->nullable(); // Store the second illustration URL
            $table->timestamps(); // Store creation and update timestamps
        });
    }


    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gardens');
    }
}
