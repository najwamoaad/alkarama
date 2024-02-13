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
        Schema::create('replacments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->timestamps();
            $table->unsignedBigInteger("inplayer_id");
            $table->foreign("inplayer_id")->references("id")->on("players")->onDelete('cascade');
            $table->unsignedBigInteger("outplayer_id");
            $table->foreign("outplayer_id")->references("id")->on("players")->onDelete('cascade');
            $table->unsignedBigInteger("matche_id");
            $table->foreign("matche_id")->references("id")->on("matches")->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('replacments');
    }
};
