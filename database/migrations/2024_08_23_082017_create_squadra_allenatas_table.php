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
        Schema::create('squadra_allenatas', function (Blueprint $table) {
            $table->id();
            $table->integer('id_utente');
            $table->integer('id_staff');
            $table->integer('id_categoria');
            $table->integer('id_stagione');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('squadra_allenatas');
    }
};
