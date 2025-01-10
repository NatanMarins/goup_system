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
        Schema::create('tomadores_pagamento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tomador_servico_id')->unique(); // Relacionamento 1 para 1 com tomadores_servicos
            $table->enum('billingType', ['BOLETO', 'CREDIT_CARD', 'PIX']); // Tipo de cobrança
            $table->decimal('value', 10, 2); // Valor
            $table->date('nextDueDate'); // Próxima data de vencimento
            $table->enum('cycle', ['YEARLY', 'MONTHLY']); // Ciclo de pagamento
            $table->text('description')->nullable(); // Descrição opcional
            $table->timestamps();

            // Configurar o relacionamento
            $table->foreign('tomador_servico_id')
                ->references('id')
                ->on('tomadores_servicos')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tomadores_pagamento');
    }
};
