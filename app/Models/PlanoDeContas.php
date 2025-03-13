<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlanoDeContas extends Model
{
    use HasFactory;

    protected $table = 'plano_de_contas';
    protected $fillable = ['classificacao', 'descricao'];

    public function balancetes(): HasMany
    {
        return $this->hasMany(Balancete::class, 'plano_de_contas_id');
    }
}

