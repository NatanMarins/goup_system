<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Socio extends Model
{
    use HasFactory;

    protected $fillable = [
        'tomador_servico_id',
        'nome',
        'identidade',
        'cpf',
        'estado_civil',
        'profissao',
        'cep',
        'estado',
        'cidade',
        'bairro',
        'logradouro',
        'numero',
        'complemento',
        'email',
        'telefone',
    ];

    // Relacionamento um-para-muitos com tomadores
    public function tomadores()
    {
        return $this->hasMany(TomadorServico::class);
    }

    // Relacionamento um-para-muitos com SociosDocumentos
    public function documentos()
    {
        return $this->hasMany(SociosDocumento::class);
    }

    //public function tomador()
    //{
        //return $this->belongsTo(TomadoresAbertura::class, 'tomadores_abertura_id');
    //}
}
