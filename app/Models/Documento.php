<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'path',
        'descricao',
        'tomador_servico_id',
    ];

    public function tomadorServico()
    {
        return $this->belongsTo(TomadorServico::class);
    }
}
