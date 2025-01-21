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
        Schema::table('documentos', function (Blueprint $table) {
            $table->string('tipo')
                ->after('id') // Ajuste a posição conforme necessário
                ->nullable()
                ->comment('Tipo de documento: Contrato Social, Alvara de Funcionamento, Inscricao Estadual');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documentos', function (Blueprint $table) {
            $table->dropColumn('tipo');
        });
    }
};
