<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TomadorServico extends Authenticatable
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tomadores_servicos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'empresa_id',
        'nome',
        'razao_social',
        'razao_social2',
        'razao_social3',
        'cnpj',
        'telefone',
        'responsavel',
        'cpf_responsavel',
        'site',
        'email',
        'nome_fantasia',
        'data_abertura',
        'inscricao_municipal',
        'cep',
        'logradouro',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'complemento',
        'cnae',
        'capital_social',
        'faturamento_anual',
        'responsavel_contabil',
        'codigo_tributacao',
        'aliquota_fiscais',
        'socio',
        'cpf',
        'participacao_societaria',
        'cargo',
        'natureza_juridica',
        'regime_tributario',
        'numero',
        'password',
        'last_login_at',
        'situacao',
        'condicao',
        'status',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'last_login_at' => 'datetime', // Converte automaticamente em Carbon
    ];


    /**
     * Get the empresa that owns the tomador de servico.
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }

    public function socios()
    {
        return $this->hasMany(Socio::class);
    }

    public function pagamento()
    {
        return $this->hasOne(TomadoresPagamento::class, 'tomador_servico_id');
    }

    public function guias()
    {
        return $this->hasMany(GuiaImposto::class);
    }
}
