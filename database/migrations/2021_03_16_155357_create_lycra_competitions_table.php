<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLycraCompetitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lycra_competitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lycra_id')->constrained('lycras');
            $table->foreignId('competition_id')->constrained('competitions');
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
        Schema::dropIfExists('lycra_competitions');
    }
}
