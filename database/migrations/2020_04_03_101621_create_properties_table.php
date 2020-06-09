<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title', 256);
            $table->text('description')->nullable();
            $table->string('address');
            $table->unsignedDecimal('price', 8, 2);
            $table->enum('host_type', ['entire place','private room','shared room']);
            $table->boolean('air_condition');
            $table->boolean('children');
            $table->boolean('hair_dryer');
            $table->boolean('parties');
            $table->boolean('pets');
            $table->boolean('smoking');
            $table->boolean('tv');
            $table->boolean('wifi');
            $table->unsignedTinyInteger('max_bedrooms');
            $table->unsignedTinyInteger('max_beds');
            $table->unsignedTinyInteger('max_guests');
            $table->timestamps();
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('profile_id');
            $table->unsignedBigInteger('property_type_id');

            $table->foreign('city_id')
                ->references('id')->on('cities')
                ->onDelete('cascade');

            $table->foreign('profile_id')
                ->references('id')->on('profiles')
                ->onDelete('cascade');

            $table->foreign('property_type_id')
                ->references('id')->on('property_types')
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
        Schema::dropIfExists('properties');
    }
}
