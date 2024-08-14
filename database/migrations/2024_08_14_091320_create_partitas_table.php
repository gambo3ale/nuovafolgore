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
        Schema::create('partitas', function (Blueprint $table) {
            $table->id();
            $table->integer('id_stagione');
            $table->integer('id_categoria');
            $table->integer('id_avversario');
            $table->integer('id_campo');
            $table->string('avversario');
            $table->string('campo');
            $table->date('data');
            $table->time('ora');
            $table->string('descrizione')->nullable();
            $table->integer('giornata')->nullable();
            $table->string('girone')->nullable();
            $table->integer('inserita')->nullable();
            $table->integer('squadra')->nullable();
            $table->string('campionato')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partitas');
    }
};
