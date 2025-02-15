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
        Schema::table('tomadores_servicos', function (Blueprint $table) {
            $table->enum('situacao', ['adimplente', 'inadimplente', 'pendente', 'abandono de carrinho'])
                  ->default('pendente')
                  ->after('nome_fantasia');

            $table->enum('condicao', ['cliente regular', 'abertura de empresa'])->default('cliente regular');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tomadores_servicos', function (Blueprint $table) {
            $table->dropColumn('situacao');
            $table->dropColumn('condicao');
        });
    }
};
