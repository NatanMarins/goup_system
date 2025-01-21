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
        Schema::create('socios', function (Blueprint $table) {
            $table->id(); // Chave primária
            $table->foreignId('tomador_servico_id')->constrained('tomadores_servicos')->onDelete('cascade'); // Chave estrangeira para tomadores
            $table->string('nome');
            $table->string('identidade');
            $table->string('estado_civil');
            $table->string('profissao');
            $table->string('cpf');
            $table->string('email');
            $table->string('telefone')->nullable();
            $table->string('numero');
            $table->string('logradouro');
            $table->string('bairro');
            $table->string('cidade');
            $table->string('estado');
            $table->string('cep');
            $table->string('complemento')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('socios');
    }
};
