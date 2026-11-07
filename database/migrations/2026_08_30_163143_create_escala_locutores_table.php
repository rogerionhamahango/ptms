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
        Schema::create('escala_locutores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jornalist_id')
                ->constrained('jornalists')
                ->onDelete('cascade');
            $table-> date('data');
            $table->string('turno');   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('escala_locutores');
    }
};
