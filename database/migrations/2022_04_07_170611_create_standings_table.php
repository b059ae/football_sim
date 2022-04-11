<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStandingsTable extends Migration
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
            $table->tinyInteger('team_id')->unsigned()->unique();
            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->onDelete('cascade');
            $table->tinyInteger('points')->unsigned()->default(0);
            $table->tinyInteger('wins')->unsigned()->default(0);
            $table->tinyInteger('drafts')->unsigned()->default(0);
            $table->tinyInteger('loses')->unsigned()->default(0);
            $table->smallInteger('goals_diff')->default(0);
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
}
