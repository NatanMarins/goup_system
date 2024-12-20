<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Documento;
use App\Models\Socio;
use App\Models\TomadoresAbertura;
use App\Models\TomadorServico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TomadorServicoController extends Controller
{
    public function index(Request $request)
    {

        // Captura os parâmetros de filtro
        $situacao = $request->input('situacao');
        $status = $request->input('status');
        $condicao = $request->input('condicao');

        // Inicia a query
        $tomadores = TomadorServico::query();

        // Aplica os filtros dinamicamente
        if ($situacao) {
            $tomadores->where('situacao', $situacao);
        }

        if ($status) {
            $tomadores->where('status', $status);
        }

        if ($condicao) {
            $tomadores->where('condicao', $condicao);
        }

        // Ordena alfabeticamente por nome (ou ajuste para a coluna que deseja)
        $clientes = $tomadores->orderBy('nome_fantasia')->paginate(10);

        return view('empresas.tomador.index', compact('clientes'));
    }

    public function show($tomadorservico)
    {
        $tomador = TomadorServico::with('socios', 'documentos')->findOrFail($tomadorservico);

        $socios = $tomador->socios;

        return view('empresas.tomador.show', compact('tomador', 'socios'));
    }

    public function documentos($tomadorservico)
    {
        $tomador = TomadorServico::with('socios', 'documentos')->findOrFail($tomadorservico);

        $documentos = $tomador->documentos;

        return view('empresas.tomador.documentos', compact('tomador', 'documentos'));
    }

    public function create()
    {

        return view('empresas.tomador.create');
    }

    public function store(Request $request)
    {
        $empresaId = Auth::user()->empresa_id;

        $request->validate([
            'nome' => 'required|string|max:255',
            'cnpj' => 'nullable|cnpj',
            'telefone' => 'required',
            'email' => 'required|email',
            'data_abertura' => 'nullable',
            'site' => 'nullable|url',
            'inscricao_municipal' => 'nullable',
            'cep' => 'required',
            'logradouro' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'estado' => 'required',
            'cnae' => 'nullable',
            'capital_social' => 'nullable',
            'faturamento_anual' => 'required',
            'responsavel_contabil' => 'nullable',
            'codigo_tributacao' => 'nullable',
            'aliquota_fiscais' => 'nullable',
            'natureza_juridica' => 'nullable',
            'regime_tributario' => 'nullable',
        ], [
            // Mensagens de erro
            'nome.required' => 'O campo Nome é obrigatório.',
            'cnpj.cnpj' => 'Informe um CNPJ válido para o campo CNPJ.',
            'telefone.required' => 'O campo Telefone é obrigatório.',
            'email.required' => 'O campo E-mail é obrigatório.',
            'email.email' => 'Informe um E-mail válido para o campo E-mail.',
            'site.url' => 'Informe uma URL válida.',
            'cep.required' => 'O campo CEP é obrigatório.',
            'logradouro.required' => 'O campo Logradouro é obrigatório.',
            'numero.required' => 'O campo Número é obrigatório.',
            'bairro.required' => 'O campo Bairro é obrigatório.',
            'cidade.required' => 'O campo Cidade é obrigatório.',
            'estado.required' => 'O campo Estado é obrigatório.',
        ]);

        TomadorServico::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'nome_fantasia' => $request->nome_fantasia,
            'cnpj' => $request->cnpj,
            'telefone' => $request->telefone,
            'site' => $request->site,
            'cep' => $request->cep,
            'numero' => $request->numero,
            'logradouro' => $request->logradouro,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => $request->estado,
            'complemento' => $request->complemento,
            'regime_tributario' => $request->regime_tributario,
            'data_abertura' => $request->data_abertura,
            'inscricao_municipal' => $request->inscricao_municipal,
            'natureza_juridica' => $request->natureza_juridica,
            'cnae' => $request->cnae,
            'capital_social' => $request->capital_social,
            'aliquotas_fiscais' => $request->aliquotas_fiscais,
            'faturamento_anual' => $request->faturamento_anual,
            'responsavel_contabil' => $request->responsavel_contabil,
            'codigo_tributacao' => $request->codigo_tributacao,
            'empresa_id' => $empresaId,
            'password' => Hash::make('123456a', ['rounds' => 12]),
        ]);

        return redirect()->route('empresas.tomador.index')->with('success', 'tomador cadastrado com sucesso!');
    }


    public function edit($tomadorservico)
    {
        $cliente = TomadorServico::findOrFail($tomadorservico);

        return view('empresas.tomador.edit', compact('cliente'));
    }

    public function planos()
    {

        return view('tomadores.planos.index');
    }

    public function planosInicial()
    {

        return view('tomadores.planos.planosInicial');
    }

    public function contratacaoInicial()
    {

        return view('tomadores.planos.contratacaoInicial');
    }

    public function aberturaEmpresa()
    {

        return view('tomadores.planos.aberturaEmpresa');
    }

    public function storeAbertura(Request $request)
    {

        //dd($request->all());

        $request->validate([
            'razao_social' => 'required|string|max:255',
            'razao_social2' => 'required|string|max:255',
            'razao_social3' => 'required|string|max:255',
            'nome_fantasia' => 'required|string|max:255',
            'email' => 'required|string|email',
            'cep' => 'required',
            'logradouro' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'estado' => 'required',
            'complemento' => 'nullable',

            'socios.*.nome' => 'required|string|max:255',
            'socios.*.identidade' => 'required|string|max:20',
            'socios.*.cpf' => 'required|string|max:14',
            'socios.*.estado_civil' => 'required|string|max:50',
            'socios.*.profissao' => 'required|string|max:100',
            'socios.*.cep' => 'required|string|max:10',
            'socios.*.estado' => 'required|string|max:2',
            'socios.*.cidade' => 'required|string|max:100',
            'socios.*.bairro' => 'required|string|max:100',
            'socios.*.logradouro' => 'required|string|max:255',
            'socios.*.numero' => 'required|string|max:10',
            'socios.*.complemento' => 'nullable|string|max:255',
            'socios.*.documentos' => 'nullable|array',
            'socios.*.documentos.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,txt',
        ], [
            // Mensagens de erro
            'razao_social.required' => 'O campo Razão social 1 é obrigatório.',
            'razao_social2.required' => 'O campo Razão social 2 é obrigatório.',
            'razao_social3.required' => 'O campo Razão social 3 é obrigatório.',
            'nome_fantasia.required' => 'O campo Nome Fantasia é obrigatório.',
            'cep.required' => 'O campo CEP é obrigatório.',
            'logradouro.required' => 'O campo Logradouro é obrigatório.',
            'numero.required' => 'O campo Número é obrigatório.',
            'bairro.required' => 'O campo Bairro é obrigatório.',
            'cidade.required' => 'O campo Cidade é obrigatório.',
            'estado.required' => 'O campo Estado é obrigatório.',
        ]);

        // Criar o tomador de serviço principal
        $tomador = TomadorServico::create(array_merge(
            $request->only([
                'razao_social',
                'razao_social2',
                'razao_social3',
                'nome_fantasia',
                'email',
                'cep',
                'estado',
                'cidade',
                'bairro',
                'logradouro',
                'numero',
                'complemento',
            ]),
            ['empresa_id' => 1, 'password' => Hash::make('123456a', ['rounds' => 12]), 'condicao' => 'abertura de empresa']
        ));

        // Processar e salvar os sócios
        if ($request->has('socios')) {
            foreach ($request->socios as $socio) {
                // Criar o sócio e associá-lo ao tomador
                $novoSocio = $tomador->socios()->create($socio);

                // Processar os documentos do sócio, caso existam
                if (isset($socio['documentos']) && is_array($socio['documentos'])) {
                    foreach ($socio['documentos'] as $documento) {
                        if ($documento->isValid()) {
                            // Fazer upload do arquivo
                            $nomeArquivo = $documento->getClientOriginalName();
                            $caminho = $documento->store('documentos_socios', 'public'); // Salva no diretório "documentos_socios"

                            // Salvar o documento na tabela "socios_documentos"
                            $novoSocio->documentos()->create([
                                'caminho' => $caminho,
                                'descricao' => $nomeArquivo
                            ]);
                        }
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Cadastro realizado com sucesso!');
    }

    public function trocaContador()
    {


        return view('tomadores.planos.trocaContador');
    }

    public function storeTroca(Request $request)
    {
        // Validação dos campos
        $request->validate([
            'razao_social' => 'required|string|max:255',
            'nome_fantasia' => 'required|string|max:255',
            'cnpj' => 'required',
            'inscricao_municipal' => 'required|string|max:255',
            'inscricao_estadual' => 'required|string|max:255',
            'email' => 'required|string|email',
            'cep' => 'required',
            'logradouro' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'estado' => 'required',
            'complemento' => 'nullable',
            'documentos_empresa.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,txt',

            'socios.*.nome' => 'required|string|max:255',
            'socios.*.identidade' => 'required|string|max:20',
            'socios.*.cpf' => 'required|string|max:14',
            'socios.*.estado_civil' => 'required|string|max:50',
            'socios.*.profissao' => 'required|string|max:100',
            'socios.*.cep' => 'required|string|max:10',
            'socios.*.estado' => 'required|string|max:2',
            'socios.*.cidade' => 'required|string|max:100',
            'socios.*.bairro' => 'required|string|max:100',
            'socios.*.logradouro' => 'required|string|max:255',
            'socios.*.numero' => 'required|string|max:10',
            'socios.*.complemento' => 'nullable|string|max:255',
            'socios.*.documentos.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,txt',
        ]);

        // Criar o tomador de serviço principal
        $tomador = TomadorServico::create(array_merge(
            $request->only([
                'razao_social',
                'cnpj',
                'inscricao_municipal',
                'inscricao_estadual',
                'nome_fantasia',
                'email',
                'cep',
                'estado',
                'cidade',
                'bairro',
                'logradouro',
                'numero',
                'complemento',
            ]),
            ['empresa_id' => 1, 'password' => Hash::make('123456a', ['rounds' => 12]), 'situacao' => $request->situacao, 'condicao' => $request->condicao]
        ));


        // Upload dos documentos da empresa
        if ($request->hasFile('documentos_empresa')) {

            foreach ($request->file('documentos_empresa') as $file) {
                if ($file->isValid()) {
                    // Salva no diretório "documentos_empresa" no disco "public"
                    $nomeArquivo = $file->getClientOriginalName();

                    $path = $file->store('documentos_empresa', 'public');
                    // Salva o documento na tabela "documentos"
                    Documento::create([
                        'tomador_servico_id' => $tomador->id,
                        'path' => $path, // Caminho do arquivo armazenado
                        'descricao' => $nomeArquivo,
                    ]);
                }
            }
        }

        // Processar e salvar os sócios
        if ($request->has('socios')) {
            foreach ($request->socios as $socio) {
                // Criar o sócio e associá-lo ao tomador
                $novoSocio = $tomador->socios()->create($socio);

                // Processar os documentos do sócio, caso existam
                if (isset($socio['documentos']) && is_array($socio['documentos'])) {
                    foreach ($socio['documentos'] as $documento) {
                        if ($documento->isValid()) {
                            // Fazer upload do arquivo
                            $nomeArquivo = $documento->getClientOriginalName();
                            $caminho = $documento->store('documentos_socios', 'public'); // Salva no diretório "documentos_socios"

                            // Salvar o documento na tabela "socios_documentos"
                            $novoSocio->documentos()->create([
                                'caminho' => $caminho,
                                'descricao' => $nomeArquivo,
                            ]);
                        }
                    }
                }
            }
        }

        // Retornar sucesso
        return redirect()->back()->with('success', 'Cadastro realizado com sucesso!');
    }
}
