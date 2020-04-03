<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedTinyInteger('adults');
            $table->unsignedTinyInteger('children');
            $table->unsignedDecimal('price', 8, 2);
            $table->enum('status', ['cancelled', 'awaiting', 'confirmed']);
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
        Schema::dropIfExists('bookings');
    }
}
