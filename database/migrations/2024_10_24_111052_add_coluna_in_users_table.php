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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nome_completo');
            $table->string('cpf');
            $table->date('data_nascimento');
            $table->string('telefone');
            $table->string('cargo');
            $table->boolean('status')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nome_completo');
            $table->dropColumn('cpf');
            $table->dropColumn('data_nascimento');
            $table->dropColumn('telefone');
            $table->dropColumn('cargo');
            $table->dropColumn('status');
        });
    }
};
