<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('lancamento_extrato', function (Blueprint $table) {
            $table->id();
            $table->date('data_lancamento');
            $table->string('historico');
            $table->text('descricao')->nullable();
            $table->decimal('valor', 10, 2);
            $table->foreignId('tomador_id')->constrained('tomadores_servicos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lancamento_extrato');
    }
};