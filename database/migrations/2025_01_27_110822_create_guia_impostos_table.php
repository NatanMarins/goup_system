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
        Schema::create('guia_impostos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tomador_servico_id'); // FK para tomadores_servicos
            $table->string('descricao');
            $table->string('valor', 10, 2);
            $table->date('vencimento');
            $table->string('path');
            $table->timestamps();
    
            $table->foreign('tomador_servico_id')->references('id')->on('tomadores_servicos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guia_impostos');
    }
};
