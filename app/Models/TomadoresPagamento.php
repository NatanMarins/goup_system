<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TomadoresPagamento extends Model
{
    use HasFactory;

    protected $table = 'tomadores_pagamento';

    protected $fillable = [
        'tomador_servico_id',
        'billingType',
        'value',
        'nextDueDate',
        'cycle',
        'description',
        'cupom',
        'valor_completo'
    ];

    public function tomadorServico()
    {
        return $this->belongsTo(TomadorServico::class, 'tomador_servico_id');
    }
}
