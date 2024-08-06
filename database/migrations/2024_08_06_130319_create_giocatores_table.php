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
        Schema::create('giocatores', function (Blueprint $table) {
            $table->id();
            $table->string('cognome');
            $table->string('nome');
            $table->date('data_nascita');
            $table->string('luogo_nascita');
            $table->string('indirizzo');
            $table->string('comune');
            $table->string('cap');
            $table->string('provincia');
            $table->string('telefono');
            $table->string('email');
            $table->string('codice_fiscale');
            $table->integer('portiere');
            $table->integer('id_genitore')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('giocatores');
    }
};
