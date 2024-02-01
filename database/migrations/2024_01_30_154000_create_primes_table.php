<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('primes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->string('description');
            $table->string('image');
            $table->enum('type', ['personal', 'club']);
            $table->unsignedBigInteger('seasone_id');
           

            $table->foreign('seasone_id')->references('id')->on('seasones')->onDelete('cascade');
            $table->unsignedBigInteger('sport_id');
           

            $table->foreign('sport_id')->references('id')->on('sports')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('primes');
    }
};
