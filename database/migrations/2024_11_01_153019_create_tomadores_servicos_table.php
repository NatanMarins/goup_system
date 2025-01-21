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
        Schema::create('tomadores_servicos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id');
            $table->string('nome_fantasia');
            $table->string('razao_social')->nullable();
            $table->string('cnpj')->nullable();
            $table->string('email')->nullable();;
            $table->string('telefone')->nullable();;
            $table->string('site')->nullable();
            $table->string('numero')->nullable();;
            $table->string('logradouro');
            $table->string('bairro');
            $table->string('cidade');
            $table->string('estado');
            $table->string('cep');
            $table->string('complemento')->nullable();
            $table->date('data_abertura')->nullable();
            $table->string('inscricao_municipal')->nullable();
            $table->enum('status', ['ativo', 'inativo', 'pendente'])->default('pendente');
            $table->enum('natureza_juridica', ['MEI', 'EI', 'Ltda.', 'SS', 'SA', 'SLU'])->default('MEI');
            $table->enum('regime_tributario', ['Simples Nacional', 'Lucro Presumido', 'Lucro Real'])->default('Simples Nacional');
            $table->string('cnae')->nullable();
            $table->string('capital_social')->nullable();
            $table->string('faturamento_anual')->nullable();
            $table->string('responsavel_contabil')->nullable();
            $table->string('aliquotas_fiscais')->nullable();
            $table->timestamps();

            // Relacionamento com a tabela empresas
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tomadores_servicos');
    }
};
