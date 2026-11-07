<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faltas', function (Blueprint $table) {
            $table->id();

            // Funcionário que faltou
            $table->unsignedBigInteger('funcionario_id');

            // Tipo de funcionário: App\Models\Jornalist ou App\Models\Technicians
            $table->string('funcionario_type');

            // Data da falta
            $table->date('data');

            // Turno/escala em que deveria trabalhar
            $table->string('turno');

            // Motivo/observação da falta
            $table->text('motivo')->nullable();

            // Utilizador que marcou a falta
            $table->foreignId('marcado_por')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamps();

            // Evita que a mesma pessoa tenha a mesma falta
            // registada duas vezes no mesmo dia e turno.
            $table->unique([
                'funcionario_id',
                'funcionario_type',
                'data',
                'turno'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faltas');
    }
};