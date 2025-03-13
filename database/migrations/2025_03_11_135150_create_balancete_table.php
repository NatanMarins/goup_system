<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('balancete', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plano_de_contas_id')->constrained('plano_de_contas')->onDelete('cascade');
            $table->foreignId('lancamento_extrato_id')->constrained('lancamento_extrato')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('balancete');
    }
};