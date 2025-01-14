<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assinatura extends Model
{
    use HasFactory;

    // Nome da tabela
    protected $table = 'assinaturas';

    // Colunas que podem ser preenchidas via mass assignment
    protected $fillable = [
        'planos',
        'valor_mensal',
        'valor_anual',
    ];

    // Caso precise adicionar casts para os valores
    protected $casts = [
        'valor_mensal' => 'float',
        'valor_anual' => 'float',
    ];
}
