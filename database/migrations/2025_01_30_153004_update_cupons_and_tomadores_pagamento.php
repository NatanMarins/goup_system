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
        Schema::table('cupons', function (Blueprint $table) {
            $table->integer('percentual')->change(); // Altera o tipo para inteiro
        });

        // Adiciona colunas na tabela tomadores_pagamento
        Schema::table('tomadores_pagamento', function (Blueprint $table) {
            $table->string('cupom')->nullable(); // Cupom pode ser nulo
            $table->decimal('valor_completo', 10, 2)->nullable(); // Define precisão decimal
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverte as mudanças na tabela cupoms
        Schema::table('cupons', function (Blueprint $table) {
            $table->string('percentual')->change(); // Retorna para string
        });

        // Remove as colunas adicionadas
        Schema::table('tomadores_pagamento', function (Blueprint $table) {
            $table->dropColumn(['cupom', 'valor_completo']);
        });
    }
};
