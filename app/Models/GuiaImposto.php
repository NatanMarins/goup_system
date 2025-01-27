<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuiaImposto extends Model
{
    use HasFactory;

    protected $fillable = ['descricao', 'vencimento', 'path', 'tomador_id'];

    public function tomador()
    {
        return $this->belongsTo(TomadorServico::class);
    }
}
