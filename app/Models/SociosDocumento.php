<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SociosDocumento extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'caminho',
        'descricao',
        'socio_id',
    ];

    // Relacionamento com Sócio
    public function socio()
    {
        return $this->belongsTo(Socio::class);
    }
}
