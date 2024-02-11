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
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->timestamps();
            $table->dateTime('datetime');
            $table->enum('status', ['not_started', 'finished','life']);
            enum('status', ['personal', 'club']);
            $table->string('channel');
            $table->tinyInteger('round');
            $table->string('play_ground');
            $table->unsignedBigInteger("session_id");
            $table->foreign("session_id")->references("id")->on("seasones")->onDelete('cascade');
            $table->unsignedBigInteger("club1_id");
            $table->foreign("club1_id")->references("id")->on("clubs")->onDelete('cascade');
            $table->unsignedBigInteger("club2_id");
            $table->foreign("club2_id")->references("id")->on("clubs")->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
};
