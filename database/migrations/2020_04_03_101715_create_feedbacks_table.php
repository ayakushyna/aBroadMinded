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
            $table->text('body');
            $table->timestamps();
            $table->unsignedBigInteger('id_profile');
            $table->unsignedBigInteger('id_property');

            $table->foreign('id_profile')
                ->references('id')->on('profiles')
                ->onDelete('cascade');

            $table->foreign('id_property')
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
