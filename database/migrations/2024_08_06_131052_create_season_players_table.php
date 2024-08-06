<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('season_players', function (Blueprint $table) {
            $table->id();
            $table->integer('id_giocatore');
            $table->integer('id_stagione');
            $table->date('iscrizione');
            $table->date('scadenza');
            $table->string('matricola');
            $table->date('autocer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('season_players');
    }
};
