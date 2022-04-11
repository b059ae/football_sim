<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->tinyInteger('team_a')->unsigned();
            $table->foreign('team_a')
                ->references('id')
                ->on('teams')
                ->onDelete('cascade');
            $table->tinyInteger('team_a_goals')->unsigned()->nullable();
            $table->tinyInteger('team_b_goals')->unsigned()->nullable();
            $table->tinyInteger('team_b')->unsigned();
            $table->foreign('team_b')
                ->references('id')
                ->on('teams')
                ->onDelete('cascade');
            $table->unique(["team_a", "team_b"]);
            $table->tinyInteger('week')->unsigned();
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
        Schema::dropIfExists('games');
    }
}
