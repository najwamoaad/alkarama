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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('player_id');
            // Add foreign key constraint
            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
            $table->unsignedBigInteger('matche_id');
            // Add foreign key constraint
            $table->foreign('matche_id')->references('id')->on('matches')->onDelete('cascade');
            $table->enum('status', ['main', 'beanch']);
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
        Schema::dropIfExists('plans');
    }
};
