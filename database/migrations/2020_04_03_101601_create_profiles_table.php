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
            $table->unsignedBigInteger('id')->unique();
            $table->string('first_name', 256);
            $table->string('last_name', 256);
            $table->enum('gender', ['undefined', 'female', 'male']);
            $table->date('birthday');
            $table->string('photo')->nullable();
            $table->text('contact_info')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('city_id');

            $table->foreign('city_id')
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
