<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assinatura;
use App\Models\Cnae;
use App\Models\cupom;
use App\Models\Documento;
use App\Models\Socio;
use App\Models\TomadoresAbertura;
use App\Models\TomadoresPagamento;
use App\Models\TomadorServico;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Mockery\Generator\StringManipulation\Pass\Pass;

class TomadorServicoController extends Controller
{
    public function index(Request $request)
    {
        $assinaturas = TomadoresPagamento::whereNotNull('codigo_assinatura')->pluck('codigo_assinatura');

        $assinaturasDetalhadas = [];
        foreach ($assinaturas as $codigo) {
            $assinaturasDetalhadas[] = $this->getSubscriptionById($codigo);
        }

        // Inicia a query base
        $query = TomadorServico::query();

        // Aplica filtros se enviados no request
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('condicao')) {
            $query->where('condicao', $request->condicao);
        }

        if ($request->filled('situacao')) {
            $query->where('situacao', $request->situacao);
        }

        if ($request->filled('nome')) {
            $query->where('nome_fantasia', 'like', '%' . $request->nome . '%');
        }

        // Ordena e carrega os resultados
        $clientes = $query->orderBy('nome_fantasia', 'asc')->paginate(20); // com paginação

        // Retorna a view com os dados e os filtros ativos
        return view('empresas.tomador.index', compact('clientes', 'request'));
    }

    private function getSubscriptionById($id)
    {
        $client = new Client();

        try {
            $response = $client->request('GET', "https://api-sandbox.asaas.com/v3/subscriptions/{$id}", [
                'headers' => [
                    'Accept' => 'application/json',
                    'access_token' => env('ASAAS_ACCESS_TOKEN'), // Pegando do .env
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return ['error' => 'Erro na API: ' . $e->getResponse()->getBody()->getContents()];
        } catch (\Exception $e) {
            return ['error' => 'Erro inesperado: ' . $e->getMessage()];
        }
    }

    public function pdfDados($tomadorservico)
    {
        $tomador = TomadorServico::with('socios')->findOrFail($tomadorservico);

        $socios = $tomador->socios;

        $pdf = Pdf::loadView('empresas.tomador.pdfDados', compact('tomador', 'socios'));

        return $pdf->download('pdfDados.pdf');
    }

    public function show($tomadorservico)
    {
        $tomador = TomadorServico::with('socios', 'documentos')->findOrFail($tomadorservico);

        $socios = $tomador->socios;

        return view('empresas.tomador.show', compact('tomador', 'socios'));
    }

    public function documentos($tomadorservico)
    {
        $tomador = TomadorServico::with('documentos')->findOrFail($tomadorservico);

        return view('empresas.tomador.documentos', compact('tomador'));
    }

    public function storeDocumentos(Request $request, $tomadorservico)
    {
        // Validar os arquivos enviados
        $request->validate([
            'contrato_social.*' => 'file|mimes:pdf,jpeg,png',
            'alvara_funcionamento.*' => 'file|mimes:pdf,jpeg,png',
            'inscricao_estadual.*' => 'file|mimes:pdf,jpeg,png',
        ]);

        // Array para armazenar os dados a serem inseridos
        $documentos = [];

        // Iterar sobre os campos de arquivos
        foreach (['contrato_social', 'alvara_funcionamento', 'inscricao_estadual'] as $tipo) {
            if ($request->hasFile($tipo)) {
                foreach ($request->file($tipo) as $file) {
                    // Gerar um identificador único para o arquivo
                    $filename = uniqid() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('documentos', $filename);

                    // Adicionar os dados ao array
                    $documentos[] = [
                        'tipo' => ucfirst(str_replace('_', ' ', $tipo)), // Converte para "Contrato Social", etc.
                        'path' => $path,
                        'descricao' => $file->getClientOriginalName(),
                        'tomador_servico_id' => $tomadorservico,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        // Inserir os dados no banco de dados
        \Illuminate\Support\Facades\DB::table('documentos')->insert($documentos);

        return redirect()->back()->with('success', 'Documentos adicionados com sucesso!');
    }

    public function destroyDocumento($id)
    {
        try {
            // Encontre o documento pelo ID
            $documento = Documento::findOrFail($id);

            // Exclua o arquivo físico do storage
            if (Storage::exists($documento->path)) {
                Storage::delete($documento->path);
            }

            // Exclua o registro no banco de dados
            $documento->delete();

            // Redirecione com sucesso
            return redirect()->back()->with('success', 'Documento excluído com sucesso.');
        } catch (\Exception $e) {
            // Redirecione com erro
            return redirect()->back()->with('error', 'Erro ao excluir documento: ' . $e->getMessage());
        }
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
        $tomador = TomadorServico::findOrFail($tomadorservico);

        return view('empresas.tomador.edit', compact('tomador'));
    }

    public function update(Request $request, $tomadorservico)
    {
        // Validação dos dados recebidos
        $validated = $request->validate([
            'responsavel' => 'nullable|string|max:255',
            'cpf_responsavel' => 'nullable|cpf',
            'nome_fantasia' => 'nullable|string|max:255',
            'razao_social' => 'nullable|string|max:255',
            'cnpj' => 'nullable|cnpj',
            'telefone' => 'nullable|string|max:20',
            'cep' => 'nullable|string|max:9',
            'estado' => 'nullable|string|max:2',
            'cidade' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:255',
            'logradouro' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'complemento' => 'nullable|string|max:255',
        ]);

        // Encontrar o tomador pelo ID
        $tomador = TomadorServico::findOrFail($tomadorservico);

        // Atualizar os dados do tomador
        $tomador->update([
            'responsavel' => $validated['responsavel'],
            'cpf_responsavel' => $validated['cpf_responsavel'],
            'nome_fantasia' => $validated['nome_fantasia'],
            'razao_social' => $validated['razao_social'],
            'cnpj' => $validated['cnpj'],
            'telefone' => $validated['telefone'],
            'cep' => $validated['cep'],
            'estado' => $validated['estado'],
            'cidade' => $validated['cidade'],
            'bairro' => $validated['bairro'],
            'logradouro' => $validated['logradouro'],
            'numero' => $validated['numero'],
            'complemento' => $validated['complemento'],
        ]);

        // Redirecionar com mensagem de sucesso
        return redirect()->route('empresas.tomador.index')->with('success', 'tomador atualizado com sucesso!');
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
        $tomadorservico = TomadorServico::all();

        $assinaturas = Assinatura::all();

        foreach ($assinaturas as $assinatura) {
            if ($assinatura->planos == 'Empreendedor') {
                $empreendedorMensal = $assinatura->valor_mensal;
                $empreendedorAnual = $assinatura->valor_anual;
            }
            if ($assinatura->planos == 'Visionário') {
                $visionarioMensal = $assinatura->valor_mensal;
                $visionarioAnual = $assinatura->valor_anual;
            }
            if ($assinatura->planos == 'Líder') {
                $liderMensal = $assinatura->valor_mensal;
                $liderAnual = $assinatura->valor_anual;
            }
        }


        return view('tomadores.planos.aberturaEmpresa', compact('tomadorservico', 'empreendedorMensal', 'empreendedorAnual', 'visionarioMensal', 'visionarioAnual', 'liderMensal', 'liderAnual'));
    }

    public function storeAbertura(Request $request)
    {
        $request->validate([
            'razao_social' => 'required|string|max:255',
            'razao_social2' => 'required|string|max:255',
            'razao_social3' => 'required|string|max:255',
            'nome_fantasia' => 'required|string|max:255',
            'email' => 'required|string|email',
            'telefone' => 'required',
            'responsavel' => 'required',
            'cpf_responsavel' => 'required|cpf',
            'cep' => 'required',
            'logradouro' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'estado' => 'required',
            'complemento' => 'nullable',
            'plano' => 'required|in:empreendedor,visionario,lider',
            'cupom' => 'nullable|string|exists:cupons,codigo',
        ], [
            // Mensagens de erro
            'razao_social.required' => 'O campo Razão social 1 é obrigatório.',
            'razao_social2.required' => 'O campo Razão social 2 é obrigatório.',
            'razao_social3.required' => 'O campo Razão social 3 é obrigatório.',
            'nome_fantasia.required' => 'O campo Nome Fantasia é obrigatório.',
            'email.required' => 'O campo Nome E-mail é obrigatório.',
            'email.email' => 'Informe um E-Mail válido.',
            'telefone.required' => 'O campo Nome Telefone é obrigatório.',
            'responsavel.required' => 'O campo Nome Responsável é obrigatório.',
            'cpf_responsavel.required' => 'O campo CPF é obrigatório.',
            'cpf_responsavel.cpf' => 'Informe um CPF válido.',
            'cep.required' => 'O campo CEP é obrigatório.',
            'logradouro.required' => 'O campo Logradouro é obrigatório.',
            'numero.required' => 'O campo Número é obrigatório.',
            'bairro.required' => 'O campo Bairro é obrigatório.',
            'cidade.required' => 'O campo Cidade é obrigatório.',
            'estado.required' => 'O campo Estado é obrigatório.',
            'plano.required' => 'Você deve selecionar um plano antes de continuar.',
            'plano.in' => 'O plano selecionado é inválido.',
            'cupom.exists' => 'O cupom informado não é válido.',
        ]);

        // Criar o tomador de serviço principal
        $tomador = TomadorServico::create(array_merge(
            $request->only([
                'razao_social',
                'razao_social2',
                'razao_social3',
                'nome_fantasia',
                'email',
                'telefone',
                'responsavel',
                'cpf_responsavel',
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

        if ($request->cupom) {
            // Recuperando os dados do cupom adicionado
            $cupom = cupom::where('codigo', $request->cupom)->first();
            $cupom_percentual = $cupom->percentual;
        }


        // Recuperando os dados da assinatura
        $assinaturas = Assinatura::all();
        foreach ($assinaturas as $assinatura) {
            if ($assinatura->planos == 'Empreendedor') {
                $empreendedorMensal = $assinatura->valor_mensal;
                $empreendedorAnual = $assinatura->valor_anual;
            }
            if ($assinatura->planos == 'Visionário') {
                $visionarioMensal = $assinatura->valor_mensal;
                $visionarioAnual = $assinatura->valor_anual;
            }
            if ($assinatura->planos == 'Líder') {
                $liderMensal = $assinatura->valor_mensal;
                $liderAnual = $assinatura->valor_anual;
            }
        }

        $paymentCiclo = $request->cycle;

        // Calculando o valor com base no cupom adicionado
        if (!$request->filled('cupom')) {
            // O cupom não foi preenchido ou é uma string vazia
            if ($request->plano == 'lider') {
                if ($paymentCiclo == 'YEARLY') {
                    $valor = $liderAnual;
                    $descricao = 'Plano Líder';
                } else {
                    $valor = $liderMensal;
                    $descricao = 'Plano Líder';
                }
            } elseif ($request->plano == 'visionario') {
                if ($paymentCiclo == 'YEARLY') {
                    $valor = $visionarioAnual;
                    $descricao = 'Plano Visionário';
                } else {
                    $valor = $visionarioMensal;
                    $descricao = 'Plano Visionário';
                }
            } elseif ($request->plano == 'empreendedor') {
                if ($paymentCiclo == 'YEARLY') {
                    $valor = $empreendedorAnual;
                    $descricao = 'Plano Empreendedor';
                } else {
                    $valor = $empreendedorMensal;
                    $descricao = 'Plano Empreendedor';
                }
            }
        } else {
            // O cupom foi preenchido
            if ($request->plano == 'lider') {
                if ($paymentCiclo == 'YEARLY') {
                    $valor = $liderAnual - ($liderAnual * $cupom_percentual) / 100;
                    $descricao = 'Plano Líder';
                } else {
                    $valor = $liderMensal - ($liderMensal * $cupom_percentual) / 100;
                    $descricao = 'Plano Líder';
                }
            } elseif ($request->plano == 'visionario') {
                if ($paymentCiclo == 'YEARLY') {
                    $valor = $visionarioAnual - ($visionarioAnual * $cupom_percentual) / 100;
                    $descricao = 'Plano Visionário';
                } else {
                    $valor = $visionarioMensal - ($visionarioMensal * $cupom_percentual) / 100;;
                    $descricao = 'Plano Visionário';
                }
            } elseif ($request->plano == 'empreendedor') {
                if ($paymentCiclo == 'YEARLY') {
                    $valor = $empreendedorAnual - ($empreendedorAnual * $cupom_percentual) / 100;;
                    $descricao = 'Plano Empreendedor';
                } else {
                    $valor = $empreendedorMensal - ($empreendedorMensal * $cupom_percentual) / 100;;
                    $descricao = 'Plano Empreendedor';
                }
            }
        }


        // Cadastrar informações na tabela tomadores_pagamento
        $tomadorPagamento = TomadoresPagamento::create([
            'tomador_servico_id' => $tomador->id,
            'billingType' => $request->billingType,
            'value' => $valor,
            'nextDueDate' => Carbon::now()->addDay()->format('Y-m-d'), // Adiciona 1 dia à data atual,
            'cycle' => $paymentCiclo,
            'description' => $descricao,
            'cupom' => $request->cupom,
        ]);

        // Enviar os dados para a API do Asaas
        $asaasResponse = $this->createCustomerAbertura($request);

        // Verificar se a API respondeu com sucesso
        $responseData = $asaasResponse->getData(); // Obtém os dados decodificados
        if (isset($responseData->status) && $responseData->status === 'success') {
            // Chamar a função para buscar o cliente pela API
            $this->getCustomerByCpfCnpjAbertura($request, $tomador);
        }

        // Após criar o tomador e salvar as informações na tabela "tomadores_pagamento"
        $billingType = $request->billingType; // Ex: "CREDIT_CARD"
        $cycle = $request->cycle; // Ex: "WEEKLY"
        $customerId = $tomador->codigo_cliente; // ID do cliente no Asaas
        $value = $valor; // Valor definido baseado no plano
        $nextDueDate = Carbon::now()->addDay()->format('Y-m-d'); // Data de vencimento
        $description = $descricao; // Descrição do plano

        // Chama a função para criar a assinatura
        $subscriptionResponse = $this->createSubscription($billingType, $cycle, $customerId, $value, $nextDueDate, $description, $tomadorPagamento);

        if (isset($subscriptionResponse['error'])) {
            return redirect()->back()->with('error', 'Erro ao criar a assinatura: ' . $subscriptionResponse['error']);
        }

        // Assinatura criada com sucesso
        return redirect()->route('tomadores.planos.welcomeVideo')->with('success', 'Cliente e assinatura criados com sucesso!');
    }



    public function trocaContador()
    {
        $tomadorservico = TomadorServico::all();

        $assinaturas = Assinatura::all();

        foreach ($assinaturas as $assinatura) {
            if ($assinatura->planos == 'Empreendedor') {
                $empreendedorMensal = $assinatura->valor_mensal;
                $empreendedorAnual = $assinatura->valor_anual;
            }
            if ($assinatura->planos == 'Visionário') {
                $visionarioMensal = $assinatura->valor_mensal;
                $visionarioAnual = $assinatura->valor_anual;
            }
            if ($assinatura->planos == 'Líder') {
                $liderMensal = $assinatura->valor_mensal;
                $liderAnual = $assinatura->valor_anual;
            }
        }

        return view('tomadores.planos.trocaContador', compact('tomadorservico', 'empreendedorMensal', 'empreendedorAnual', 'visionarioMensal', 'visionarioAnual', 'liderMensal', 'liderAnual'));
    }

    public function storeTroca(Request $request)
    {
        // Validação dos campos
        $request->validate([
            'razao_social' => 'required|string|max:255',
            'nome_fantasia' => 'required|string|max:255',
            'cnpj' => 'required|cnpj',
            'inscricao_municipal' => 'nullable|string|max:255',
            'inscricao_estadual' => 'nullable|string|max:255',
            'email' => 'required|string|email',
            'telefone' => 'required',
            'cep' => 'required',
            'logradouro' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'estado' => 'required',
            'complemento' => 'nullable',
            'plano' => 'required|in:empreendedor,visionario,lider',
            'cupom' => 'nullable|string|exists:cupons,codigo',
        ], [
            // Mensagens de erro
            'razao_social.required' => 'O campo Razão social 1 é obrigatório.',
            'nome_fantasia.required' => 'O campo Nome Fantasia é obrigatório.',
            'cnpj.required' => 'O campo Nome Fantasia é obrigatório.',
            'cnpj.cnpj' => 'Informe um CNPJ válido.',
            'email.required' => 'O campo Nome E-mail é obrigatório.',
            'email.email' => 'Informe um E-Mail válido.',
            'telefone.required' => 'O campo Nome Telefone é obrigatório.',
            'responsavel.required' => 'O campo Nome Responsável é obrigatório.',
            'cpf_responsavel.required' => 'O campo CPF é obrigatório.',
            'cep.required' => 'O campo CEP é obrigatório.',
            'logradouro.required' => 'O campo Logradouro é obrigatório.',
            'numero.required' => 'O campo Número é obrigatório.',
            'bairro.required' => 'O campo Bairro é obrigatório.',
            'cidade.required' => 'O campo Cidade é obrigatório.',
            'estado.required' => 'O campo Estado é obrigatório.',
            'plano.required' => 'Você deve selecionar um plano antes de continuar.',
            'plano.in' => 'O plano selecionado é inválido.',
            'cupom.exists' => 'O cupom informado não é válido.',
        ]);

        $cnpj = $request->cnpj;

        // API para buscar CNAE
        $data = $this->consultarCnpja($cnpj);

        // Inicializa um array para armazenar os IDs de atividades
        $cnaeIds = [];

        // Adiciona o ID da mainActivity, se existir
        if (isset($data['mainActivity']['id'])) {
            $cnaeIds[] = $data['mainActivity']['id'];
        }

        // Adiciona os IDs de sideActivities, se existirem
        if (isset($data['sideActivities']) && is_array($data['sideActivities'])) {
            foreach ($data['sideActivities'] as $activity) {
                if (isset($activity['id'])) {
                    $cnaeIds[] = $activity['id'];
                }
            }
        }

        // Verifica se esses IDs existem na tabela 'cnae'
        $cnaesEncontrados = Cnae::whereIn('cnae', $cnaeIds)->pluck('cnae')->toArray();

        return response()->json([
            'cnaeIdsRecebidos' => $cnaeIds,
            'cnaesEncontrados' => $cnaesEncontrados,
            'cnaesNaoEncontrados' => array_diff($cnaeIds, $cnaesEncontrados)
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
                'telefone',
                'cep',
                'estado',
                'cidade',
                'bairro',
                'logradouro',
                'numero',
                'complemento',
            ]),
            ['empresa_id' => 1, 'password' => Hash::make('123456a', ['rounds' => 12])]
        ));

        if ($request->cupom) {
            // Recuperando os dados do cupom adicionado
            $cupom = cupom::where('codigo', $request->cupom)->first();
            $cupom_percentual = $cupom->percentual;
        }

        // Recuperando os dados da assinatura
        $assinaturas = Assinatura::all();
        foreach ($assinaturas as $assinatura) {
            if ($assinatura->planos == 'Empreendedor') {
                $empreendedorMensal = $assinatura->valor_mensal;
                $empreendedorAnual = $assinatura->valor_anual;
            }
            if ($assinatura->planos == 'Visionário') {
                $visionarioMensal = $assinatura->valor_mensal;
                $visionarioAnual = $assinatura->valor_anual;
            }
            if ($assinatura->planos == 'Líder') {
                $liderMensal = $assinatura->valor_mensal;
                $liderAnual = $assinatura->valor_anual;
            }
        }

        $paymentCiclo = $request->cycle;

        // Calculando o valor com base no cupom adicionado
        if (!$request->filled('cupom')) {
            // O cupom não foi preenchido ou é uma string vazia
            if ($request->plano == 'lider') {
                if ($paymentCiclo == 'YEARLY') {
                    $valor = $liderAnual;
                    $descricao = 'Plano Líder';
                } else {
                    $valor = $liderMensal;
                    $descricao = 'Plano Líder';
                }
            } elseif ($request->plano == 'visionario') {
                if ($paymentCiclo == 'YEARLY') {
                    $valor = $visionarioAnual;
                    $descricao = 'Plano Visionário';
                } else {
                    $valor = $visionarioMensal;
                    $descricao = 'Plano Visionário';
                }
            } elseif ($request->plano == 'empreendedor') {
                if ($paymentCiclo == 'YEARLY') {
                    $valor = $empreendedorAnual;
                    $descricao = 'Plano Empreendedor';
                } else {
                    $valor = $empreendedorMensal;
                    $descricao = 'Plano Empreendedor';
                }
            }
        } else {
            // O cupom foi preenchido
            if ($request->plano == 'lider') {
                if ($paymentCiclo == 'YEARLY') {
                    $valor = $liderAnual - ($liderAnual * $cupom_percentual) / 100;
                    $descricao = 'Plano Líder';
                } else {
                    $valor = $liderMensal - ($liderMensal * $cupom_percentual) / 100;
                    $descricao = 'Plano Líder';
                }
            } elseif ($request->plano == 'visionario') {
                if ($paymentCiclo == 'YEARLY') {
                    $valor = $visionarioAnual - ($visionarioAnual * $cupom_percentual) / 100;
                    $descricao = 'Plano Visionário';
                } else {
                    $valor = $visionarioMensal - ($visionarioMensal * $cupom_percentual) / 100;;
                    $descricao = 'Plano Visionário';
                }
            } elseif ($request->plano == 'empreendedor') {
                if ($paymentCiclo == 'YEARLY') {
                    $valor = $empreendedorAnual - ($empreendedorAnual * $cupom_percentual) / 100;;
                    $descricao = 'Plano Empreendedor';
                } else {
                    $valor = $empreendedorMensal - ($empreendedorMensal * $cupom_percentual) / 100;;
                    $descricao = 'Plano Empreendedor';
                }
            }
        }

        $tomadorPagamento = TomadoresPagamento::create([
            'tomador_servico_id' => $tomador->id,
            'billingType' => $request->billingType,
            'value' => $valor,
            'nextDueDate' => Carbon::now()->addDay()->format('Y-m-d'), // Adiciona 1 dia à data atual,
            'cycle' => $paymentCiclo,
            'description' => $descricao,
            'cupom' => $request->cupom,
        ]);



        // Enviar os dados para a API do Asaas
        $asaasResponse = $this->createCustomer($request);

        // Verificar se a API respondeu com sucesso
        $responseData = $asaasResponse->getData(); // Obtém os dados decodificados
        if (isset($responseData->status) && $responseData->status === 'success') {
            // Chamar a função para buscar o cliente pela API
            $this->getCustomerByCpfCnpj($request, $tomador);
        }

        // Após criar o tomador e salvar as informações na tabela "tomadores_pagamento"
        $billingType = $request->billingType; // Ex: "CREDIT_CARD"
        $cycle = $request->cycle; // Ex: "WEEKLY"
        $customerId = $tomador->codigo_cliente; // ID do cliente no Asaas
        $value = $valor; // Valor definido baseado no plano
        $nextDueDate = Carbon::now()->addDay()->format('Y-m-d'); // Data de vencimento
        $description = $descricao; // Descrição do plano

        // Chama a função para criar a assinatura
        $subscriptionResponse = $this->createSubscription($billingType, $cycle, $customerId, $value, $nextDueDate, $description, $tomadorPagamento);

        if (isset($subscriptionResponse['error'])) {
            return redirect()->back()->with('error', 'Erro ao criar a assinatura: ' . $subscriptionResponse['error']);
        }

        // Assinatura criada com sucesso
        return redirect()->route('tomadores.planos.welcomeVideo')->with('success', 'Cliente e assinatura criados com sucesso!');
    }




    public function regularizaMei()
    {
        $tomadorservico = TomadorServico::all();

        $assinatura = Assinatura::where('planos', 'MEI')->get()->first();

        $meiAnual = $assinatura->valor_anual;
        $meiMensal = $assinatura->valor_mensal;

        return view('tomadores.planos.regularizaMei', compact('tomadorservico', 'meiMensal', 'meiAnual'));
    }

    public function storeMei(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'sobrenome' => 'required|string|max:255',
            'email' => 'required|string|email',
            'telefone' => 'required',
            'cpf_responsavel' => 'required|cpf',
            'cep' => 'required',
            'logradouro' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'estado' => 'required',
            'complemento' => 'nullable',
            'cupom' => 'nullable|string|exists:cupons,codigo',
        ], [
            // Mensagens de erro
            'nome.required' => 'O campo Nome é obrigatório.',
            'sobrenome.required' => 'O campo Sobrenome é obrigatório.',
            'email.required' => 'O campo Nome E-mail é obrigatório.',
            'email.email' => 'Informe um E-Mail válido.',
            'telefone.required' => 'O campo Nome Telefone é obrigatório.',
            'cpf_responsavel.required' => 'O campo CPF é obrigatório.',
            'cpf_responsavel.cpf' => 'Informe um CPF válido.',
            'cep.required' => 'O campo CEP é obrigatório.',
            'logradouro.required' => 'O campo Logradouro é obrigatório.',
            'numero.required' => 'O campo Número é obrigatório.',
            'bairro.required' => 'O campo Bairro é obrigatório.',
            'cidade.required' => 'O campo Cidade é obrigatório.',
            'estado.required' => 'O campo Estado é obrigatório.',
            'cupom.exists' => 'O cupom informado não é válido.',
        ]);

        // Criar o tomador de serviço principal
        $tomador = TomadorServico::create(array_merge(
            $request->only([
                'nome',
                'sobrenome',
                'email',
                'telefone',
                'cpf_responsavel',
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

        if ($request->cupom) {
            // Recuperando os dados do cupom adicionado
            $cupom = cupom::where('codigo', $request->cupom)->first();
            $cupom_percentual = $cupom->percentual;
        }


        // Recuperando os dados da assinatura
        $assinatura = Assinatura::where('planos', 'MEI')->get()->first();

        $meiAnual = $assinatura->valor_anual;
        $meiMensal = $assinatura->valor_mensal;

        $paymentCiclo = $request->cycle;

        // Calculando o valor com base no cupom adicionado
        if (!$request->filled('cupom')) {
            // O cupom não foi preenchido ou é uma string vazia
            if ($paymentCiclo == 'YEARLY') {
                $valor = $meiAnual;
                $descricao = 'Plano MEI';
            } else {
                $valor = $meiMensal;
                $descricao = 'Plano MEI';
            }
        } else {
            // O cupom foi preenchido
            if ($paymentCiclo == 'YEARLY') {
                $valor = $meiAnual - ($meiAnual * $cupom_percentual) / 100;
                $descricao = 'Plano Líder';
            } else {
                $valor = $meiMensal - ($meiMensal * $cupom_percentual) / 100;
                $descricao = 'Plano Líder';
            }
        }


        // Cadastrar informações na tabela tomadores_pagamento
        $tomadorPagamento = TomadoresPagamento::create([
            'tomador_servico_id' => $tomador->id,
            'billingType' => $request->billingType,
            'value' => $valor,
            'nextDueDate' => Carbon::now()->addDay()->format('Y-m-d'), // Adiciona 1 dia à data atual,
            'cycle' => $paymentCiclo,
            'description' => $descricao,
            'cupom' => $request->cupom,
        ]);

        // Enviar os dados para a API do Asaas
        $asaasResponse = $this->createCustomerRegularizar($request);

        // Verificar se a API respondeu com sucesso
        $responseData = $asaasResponse->getData(); // Obtém os dados decodificados
        if (isset($responseData->status) && $responseData->status === 'success') {
            // Chamar a função para buscar o cliente pela API
            $this->getCustomerByCpfCnpjAbertura($request, $tomador);
        }

        // Após criar o tomador e salvar as informações na tabela "tomadores_pagamento"
        $billingType = $request->billingType; // Ex: "CREDIT_CARD"
        $cycle = $request->cycle; // Ex: "WEEKLY"
        $customerId = $tomador->codigo_cliente; // ID do cliente no Asaas
        $value = $valor; // Valor definido baseado no plano
        $nextDueDate = Carbon::now()->addDay()->format('Y-m-d'); // Data de vencimento
        $description = $descricao; // Descrição do plano

        // Chama a função para criar a assinatura
        $subscriptionResponse = $this->createSubscription($billingType, $cycle, $customerId, $value, $nextDueDate, $description, $tomadorPagamento);

        if (isset($subscriptionResponse['error'])) {
            return redirect()->back()->with('error', 'Erro ao criar a assinatura: ' . $subscriptionResponse['error']);
        }

        // Assinatura criada com sucesso
        return redirect()->route('tomadores.planos.welcomeVideo')->with('success', 'Cliente e assinatura criados com sucesso!');
    }

    public function regularizaEsocial()
    {
        $tomadorservico = TomadorServico::all();

        $assinatura = Assinatura::where('planos', 'E-Social')->get()->first();

        $esocialAnual = $assinatura->valor_anual;
        $esocialMensal = $assinatura->valor_mensal;

        return view('tomadores.planos.regularizaEsocial', compact('tomadorservico', 'esocialAnual', 'esocialMensal'));
    }

    public function storeEsocial(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'sobrenome' => 'required|string|max:255',
            'email' => 'required|string|email',
            'telefone' => 'required',
            'cpf_responsavel' => 'required|cpf',
            'cep' => 'required',
            'logradouro' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'estado' => 'required',
            'complemento' => 'nullable',
            'cupom' => 'nullable|string|exists:cupons,codigo',
        ], [
            // Mensagens de erro
            'nome.required' => 'O campo Nome é obrigatório.',
            'sobrenome.required' => 'O campo Sobrenome é obrigatório.',
            'email.required' => 'O campo Nome E-mail é obrigatório.',
            'email.email' => 'Informe um E-Mail válido.',
            'telefone.required' => 'O campo Nome Telefone é obrigatório.',
            'cpf_responsavel.required' => 'O campo CPF é obrigatório.',
            'cpf_responsavel.cpf' => 'Informe um CPF válido.',
            'cep.required' => 'O campo CEP é obrigatório.',
            'logradouro.required' => 'O campo Logradouro é obrigatório.',
            'numero.required' => 'O campo Número é obrigatório.',
            'bairro.required' => 'O campo Bairro é obrigatório.',
            'cidade.required' => 'O campo Cidade é obrigatório.',
            'estado.required' => 'O campo Estado é obrigatório.',
            'cupom.exists' => 'O cupom informado não é válido.',
        ]);

        // Criar o tomador de serviço principal
        $tomador = TomadorServico::create(array_merge(
            $request->only([
                'nome',
                'sobrenome',
                'email',
                'telefone',
                'cpf_responsavel',
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

        if ($request->cupom) {
            // Recuperando os dados do cupom adicionado
            $cupom = cupom::where('codigo', $request->cupom)->first();
            $cupom_percentual = $cupom->percentual;
        }


        // Recuperando os dados da assinatura
        $assinatura = Assinatura::where('planos', 'E-Social')->get()->first();

        $esocialAnual = $assinatura->valor_anual;
        $esocialMensal = $assinatura->valor_mensal;

        $paymentCiclo = $request->cycle;

        // Calculando o valor com base no cupom adicionado
        if (!$request->filled('cupom')) {
            // O cupom não foi preenchido ou é uma string vazia
            if ($paymentCiclo == 'YEARLY') {
                $valor = $esocialAnual;
                $descricao = 'Plano E-Social';
            } else {
                $valor = $esocialMensal;
                $descricao = 'Plano E-Social';
            }
        } else {
            // O cupom foi preenchido
            if ($paymentCiclo == 'YEARLY') {
                $valor = $esocialAnual - ($esocialAnual * $cupom_percentual) / 100;
                $descricao = 'Plano E-Social';
            } else {
                $valor = $esocialMensal - ($esocialMensal * $cupom_percentual) / 100;
                $descricao = 'Plano E-Social';
            }
        }

        // Cadastrar informações na tabela tomadores_pagamento
        $tomadorPagamento = TomadoresPagamento::create([
            'tomador_servico_id' => $tomador->id,
            'billingType' => $request->billingType,
            'value' => $valor,
            'nextDueDate' => Carbon::now()->addDay()->format('Y-m-d'), // Adiciona 1 dia à data atual,
            'cycle' => $paymentCiclo,
            'description' => $descricao,
            'cupom' => $request->cupom,
        ]);

        // Enviar os dados para a API do Asaas
        $asaasResponse = $this->createCustomerRegularizar($request);

        // Verificar se a API respondeu com sucesso
        $responseData = $asaasResponse->getData(); // Obtém os dados decodificados
        if (isset($responseData->status) && $responseData->status === 'success') {
            // Chamar a função para buscar o cliente pela API
            $this->getCustomerByCpfCnpjAbertura($request, $tomador);
        }

        // Após criar o tomador e salvar as informações na tabela "tomadores_pagamento"
        $billingType = $request->billingType; // Ex: "CREDIT_CARD"
        $cycle = $request->cycle; // Ex: "WEEKLY"
        $customerId = $tomador->codigo_cliente; // ID do cliente no Asaas
        $value = $valor; // Valor definido baseado no plano
        $nextDueDate = Carbon::now()->addDay()->format('Y-m-d'); // Data de vencimento
        $description = $descricao; // Descrição do plano

        // Chama a função para criar a assinatura
        $subscriptionResponse = $this->createSubscription($billingType, $cycle, $customerId, $value, $nextDueDate, $description, $tomadorPagamento);

        if (isset($subscriptionResponse['error'])) {
            return redirect()->back()->with('error', 'Erro ao criar a assinatura: ' . $subscriptionResponse['error']);
        }

        // Assinatura criada com sucesso
        return redirect()->route('tomadores.planos.welcomeVideo')->with('success', 'Cliente e assinatura criados com sucesso!');
    }

    public function welcomeVideo()
    {
        return view('tomadores.planos.welcomeVideo');
    }




    // PRIVATE FUNCTIONS

    private function createCustomerRegularizar(Request $request)
    {
        $client = new Client();

        $body = [
            'name' => $request->nome,
            'cpfCnpj' => $request->cpf_responsavel,
            'email' => $request->email,
            'mobilePhone' => $request->telefone,
            'postalCode' => $request->cep,
        ];

        try {
            $response = $client->request('POST', 'https://sandbox.asaas.com/api/v3/customers', [
                'headers' => [
                    'accept' => 'application/json',
                    'access_token' => env('ASAAS_ACCESS_TOKEN'),
                    'content-type' => 'application/json',
                ],
                'json' => $body,
            ]);

            return response()->json([
                'status' => 'success',
                'data' => json_decode($response->getBody()->getContents(), true),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    private function createCustomerAbertura(Request $request)
    {
        $client = new Client();

        $body = [
            'name' => $request->nome_fantasia,
            'cpfCnpj' => $request->cpf_responsavel,
            'email' => $request->email,
            'mobilePhone' => $request->telefone,
            'postalCode' => $request->cep,
        ];

        try {
            $response = $client->request('POST', 'https://sandbox.asaas.com/api/v3/customers', [
                'headers' => [
                    'accept' => 'application/json',
                    'access_token' => env('ASAAS_ACCESS_TOKEN'),
                    'content-type' => 'application/json',
                ],
                'json' => $body,
            ]);

            return response()->json([
                'status' => 'success',
                'data' => json_decode($response->getBody()->getContents(), true),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    private function getCustomerByCpfCnpjAbertura(Request $request, $tomador)
    {
        $cpfCnpj = $request->cpf_responsavel; // Captura o CPF ou CNPJ enviado na requisição

        if (!$cpfCnpj) {
            return response()->json(['status' => 'error', 'message' => 'CPF ou CNPJ não informado.'], 400);
        }

        $client = new Client();

        try {
            // Fazendo a requisição GET na API do Asaas
            $response = $client->request('GET', 'https://sandbox.asaas.com/api/v3/customers', [
                'headers' => [
                    'accept' => 'application/json',
                    'access_token' => env('ASAAS_ACCESS_TOKEN'), // Use o token configurado no .env
                ],
                'query' => ['cpfCnpj' => $cpfCnpj], // Passa o CPF ou CNPJ como parâmetro de consulta
            ]);

            $responseBody = json_decode($response->getBody()->getContents(), true);

            // Verifica se a API retornou um cliente válido
            if (isset($responseBody['data']) && count($responseBody['data']) > 0) {
                $customer = $responseBody['data'][0]; // Pega o primeiro cliente retornado
                $customerId = $customer['id'];

                // Salva o ID na tabela tomadores_servicos
                $tomador->codigo_cliente = $customerId;
                $tomador->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Cliente encontrado e cadastrado com sucesso!',
                    'data' => [
                        'codigo_cliente' => $customerId,
                    ],
                ]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Cliente não encontrado.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    private function createCustomer(Request $request)
    {
        $client = new Client();

        $body = [
            'name' => $request->nome_fantasia,
            'cpfCnpj' => $request->cnpj,
            'email' => $request->email,
            'mobilePhone' => $request->telefone,
            'postalCode' => $request->cep,
        ];

        try {
            $response = $client->request('POST', 'https://sandbox.asaas.com/api/v3/customers', [
                'headers' => [
                    'accept' => 'application/json',
                    'access_token' => env('ASAAS_ACCESS_TOKEN'),
                    'content-type' => 'application/json',
                ],
                'json' => $body,
            ]);

            return response()->json([
                'status' => 'success',
                'data' => json_decode($response->getBody()->getContents(), true),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    private function getCustomerByCpfCnpj(Request $request, $tomador)
    {
        $cpfCnpj = $request->cnpj; // Captura o CPF ou CNPJ enviado na requisição

        if (!$cpfCnpj) {
            return response()->json(['status' => 'error', 'message' => 'CPF ou CNPJ não informado.'], 400);
        }

        $client = new Client();

        try {
            // Fazendo a requisição GET na API do Asaas
            $response = $client->request('GET', 'https://sandbox.asaas.com/api/v3/customers', [
                'headers' => [
                    'accept' => 'application/json',
                    'access_token' => env('ASAAS_ACCESS_TOKEN'), // Use o token configurado no .env
                ],
                'query' => ['cpfCnpj' => $cpfCnpj], // Passa o CPF ou CNPJ como parâmetro de consulta
            ]);

            $responseBody = json_decode($response->getBody()->getContents(), true);

            // Verifica se a API retornou um cliente válido
            if (isset($responseBody['data']) && count($responseBody['data']) > 0) {
                $customer = $responseBody['data'][0]; // Pega o primeiro cliente retornado
                $customerId = $customer['id'];

                // Salva o ID na tabela tomadores_servicos
                $tomador->codigo_cliente = $customerId;
                $tomador->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Cliente encontrado e cadastrado com sucesso!',
                    'data' => [
                        'codigo_cliente' => $customerId,
                    ],
                ]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Cliente não encontrado.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    private function createSubscription($billingType, $cycle, $customerId, $value, $nextDueDate, $description, $tomadorPagamento)
    {
        $client = new Client();

        try {
            $response = $client->request('POST', 'https://sandbox.asaas.com/api/v3/subscriptions', [
                'json' => [ // Define os dados no formato JSON
                    'billingType' => $billingType,
                    'cycle' => $cycle,
                    'customer' => $customerId, // ID do cliente no Asaas
                    'value' => $value, // Valor da assinatura
                    'nextDueDate' => $nextDueDate, // Data de vencimento
                    'description' => $description, // Descrição da assinatura
                ],
                'headers' => [
                    'accept' => 'application/json',
                    'access_token' => env('ASAAS_ACCESS_TOKEN'),
                    'content-type' => 'application/json',
                ],
            ]);

            $responseBody = json_decode($response->getBody()->getContents(), true);

            // Verifica se a API retornou uma assinatura válida
            if (isset($responseBody['id'])) {
                $assinaturaId = $responseBody['id']; // ID correto da assinatura

                // Salva o ID na tabela tomadores_pagamento
                $tomadorPagamento->codigo_assinatura = $assinaturaId;
                $tomadorPagamento->save();

                return json_decode($response->getBody(), true); // Retorna o JSON como array associativo

            } else {
                return response()->json(['status' => 'error', 'message' => 'Assinatura não encontrada.'], 404);
            }
        } catch (\Exception $e) {
            // Trate possíveis erros
            return ['error' => $e->getMessage()];
        }
    }

    private function consultarCnpja($cnpj)
    {
        $client = new Client();

        // 🔹 Removendo pontos, barras e traços do CNPJ
        $cnpj = preg_replace('/\D/', '', $cnpj);

        try {
            $response = $client->request('GET', 'https://api.cnpja.com/office/' . $cnpj, [
                'headers' => [
                    'accept' => 'application/json',
                    'Authorization' => '981a9092-25e3-448f-bf96-cd740b644baf-e6b1d918-6e5d-4000-8b51-769771a0885c',
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            return ['error' => 'Erro ao consultar CNPJ: ' . $e->getMessage()];
        }
    }
}
