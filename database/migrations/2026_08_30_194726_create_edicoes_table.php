<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('edicoes', function (Blueprint $table) {

            $table->id();

            $table->foreignId('jornalista_id')
                ->constrained('jornalists')
                ->onDelete('cascade');

            $table->foreignId('horarios_id')
                ->constrained('horarios')
                ->onDelete('cascade');

            $table->date('data');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('edicoes');
    }
};