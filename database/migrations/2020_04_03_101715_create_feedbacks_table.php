<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('score');
            $table->string('title', 256);
            $table->text('body')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('profile_id');
            $table->unsignedBigInteger('property_id');

            $table->foreign('profile_id')
                ->references('id')->on('profiles')
                ->onDelete('cascade');

            $table->foreign('property_id')
                ->references('id')->on('properties')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedbacks');
    }
}
