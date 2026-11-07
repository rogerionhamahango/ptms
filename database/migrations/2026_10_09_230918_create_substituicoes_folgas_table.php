
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('substituicoes_folgas', function (Blueprint $table) {
            $table->id();

            // Folga a que esta substituição pertence
            $table->foreignId('folga_id')
                ->constrained('folgas')
                ->cascadeOnDelete();

            // Escala original que será coberta
            $table->unsignedBigInteger('escala_id');
            $table->string('escala_type');

            // Funcionário que fará a substituição
            $table->unsignedBigInteger('substituto_id');
            $table->string('substituto_type');

            $table->timestamps();

            // Cada compromisso só pode ter uma substituição
            $table->unique(
                ['escala_type', 'escala_id'],
                'substituicoes_escala_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('substituicoes_folgas');
    }
};
