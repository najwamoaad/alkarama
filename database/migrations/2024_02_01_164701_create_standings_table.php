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
        Schema::create('standings', function (Blueprint $table) {
            $table->id();
            $table->uuid("uuid")->unique();
            $table->integer("win");
            $table->integer("lose");
            $table->integer("draw");
            $table->integer("plus");
            $table->integer("points");
            $table->integer("play");
            $table->unsignedBigInteger("seasone_id");
            $table->unsignedBigInteger("club_id");
            $table->foreign("seasone_id")->references('id')->on("seasones")->onDelete('cascade');
            $table->foreign("club_id")->references('id')->on("clubs")->onDelete('cascade');
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
        Schema::dropIfExists('standings');
    }
};
