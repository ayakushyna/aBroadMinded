<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 256);
            $table->string('last_name', 256);
            $table->string('nickname', 256);
            $table->enum('gender', ['female', 'male']);
            $table->date('birthday');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->unsignedBigInteger('id_city');

            $table->foreign('id_city')
                ->references('id')->on('cities')
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
        Schema::dropIfExists('profiles');
    }
}
