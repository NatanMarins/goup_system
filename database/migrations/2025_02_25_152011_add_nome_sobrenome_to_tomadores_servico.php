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
            $table->string('nome')->nullable()->after('email'); // Adiciona a coluna nome
            $table->string('sobrenome')->nullable()->after('nome'); // Adiciona a coluna sobrenome
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tomadores_servicos', function (Blueprint $table) {
            $table->dropColumn(['nome', 'sobrenome']);
        });
    }
};
