<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Balancete extends Model
{
    use HasFactory;

    protected $table = 'balancete';

    protected $fillable = [
        'plano_de_contas_id',
        'lancamento_extrato_id'
    ];

    public function planoDeContas(): BelongsTo
    {
        return $this->belongsTo(PlanoDeContas::class, 'plano_de_contas_id');
    }

    public function lancamentoExtrato(): BelongsTo
    {
        return $this->belongsTo(LancamentoExtrato::class, 'lancamento_extrato_id');
    }
}