<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LancamentoExtrato extends Model
{
    use HasFactory;

    protected $table = 'lancamento_extrato';
    
    protected $fillable = [
        'data_lancamento',
        'historico',
        'descricao',
        'valor',
        'tomador_id'
    ];

    public function tomador(): BelongsTo
    {
        return $this->belongsTo(TomadorServico::class, 'tomador_id');
    }

    public function balancete(): HasMany
    {
        return $this->hasMany(Balancete::class, 'lancamento_extrato_id');
    }
}
