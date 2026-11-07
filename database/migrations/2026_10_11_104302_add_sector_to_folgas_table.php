<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('folgas', function (Blueprint $table) {
            $table->string('sector', 20)
                ->nullable()
                ->after('funcionario_type');
        });
    }

    public function down(): void
    {
        Schema::table('folgas', function (Blueprint $table) {
            $table->dropColumn('sector');
        });
    }
};
