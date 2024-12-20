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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('razao_social')->nullable();
            $table->string('cnpj')->nullable();
            $table->string('cpf')->nullable();
            $table->string('sobrenome')->nullable();
            $table->unsignedBigInteger('tomador_servico_id'); // Chave estrangeira
            $table->timestamps();

            // Definição da chave estrangeira
            $table->foreign('tomador_servico_id')
                  ->references('id')
                  ->on('tomadores_servicos')
                  ->onDelete('cascade'); // Apaga os clientes ao excluir o tomador
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
