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
        Schema::create('log_aziones', function (Blueprint $table) {
            $table->id();
            $table->integer('id_utente');
            $table->integer('id_giocatore');
            $table->integer('id_season_player');
            $table->integer('id_stagione');
            $table->string('azione');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_aziones');
    }
};
