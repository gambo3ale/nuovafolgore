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
        Schema::create('ricevutas', function (Blueprint $table) {
            $table->id();
            $table->integer('numero');
            $table->date('data');
            $table->float('importo');
            $table->string('cognome_genitore');
            $table->string('nome_genitore');
            $table->date('data_genitore');
            $table->string('luogo_genitore');
            $table->string('codce_genitore');
            $table->string('cognome_giocatore');
            $table->string('nome_giocatore');
            $table->date('data_giocatore');
            $table->string('luogo_giocatore');
            $table->string('codce_giocatore');
            $table->integer('bonifico');
            $table->date('data_bonifico');
            $table->integer('intestato');
            $table->integer('tipo');
            $table->integer('id_season_player');
            $table->integer('id_stagione');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ricevutas');
    }
};
