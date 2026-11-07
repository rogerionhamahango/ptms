

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('folgas', function (Blueprint $table) {
            $table->id();

            // Funcionário que vai beneficiar da folga
            $table->unsignedBigInteger('funcionario_id');
            $table->string('funcionario_type');

            // Data específica da folga
            $table->date('data');

            // Motivo ou observação
            $table->text('motivo')->nullable();

            // Chefe que autorizou a folga
            $table->foreignId('autorizado_por')
                ->constrained('users')
                ->restrictOnDelete();

            $table->timestamps();

            // Impede duas folgas para a mesma pessoa na mesma data
            $table->unique(
                ['funcionario_id', 'funcionario_type', 'data'],
                'folgas_funcionario_data_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('folgas');
    }
};
