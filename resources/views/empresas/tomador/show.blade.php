@extends('empresas.layout.admin')

@section('content')
    <style>
        /* Estilização adicional, caso necessário */
        .status-ativo {
            color: white;
            background-color: green;
            border-radius: 5px;
            padding: 5px 10px;
            font-size: 14px;
        }

        .status-inativo {
            color: white;
            background-color: red;
            border-radius: 5px;
            padding: 5px 10px;
            font-size: 14px;
        }

        .status-pendente {
            color: white;
            background-color: orange;
            border-radius: 5px;
            padding: 5px 10px;
            font-size: 14px;
        }
    </style>

    <!-- Cabeçalho -->
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2">
        <div>
            <h4><strong>Detalhes do Cliente</strong> <br /><small>{{ $tomador->nome_fantasia }}</small></h4>
        </div>
        <!-- botao -->
        <div class="ms-md-auto py-2 py-md-0">
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="{{ route('empresas.contabilidade.balancete', ['tomadorservico' => $tomador->id]) }}" class="btn btn-primary btn-sm" title="Gerar Balancete">
                    <i class="fa-solid fas fa-dollar-sign btn-icon-append"></i>
                </a>
                <a href="{{ route('empresas.impostos.create', ['tomadorservico' => $tomador->id]) }}" class="btn btn-primary btn-sm" title="Guias e Impostos">
                    <i class="fa-solid fas fa-dollar-sign btn-icon-append"></i>
                </a>
                <a href="{{ route('empresas.tomador.documentos', ['tomadorservico' => $tomador->id]) }}"
                    class="btn btn-primary btn-sm" title="Documentação">
                    <i class="fa-solid fas fa-file-pdf btn-icon-append"></i>
                </a>
            </div>
        </div>
        <!-- botao -->
    </div>
    <!-- Cabeçalho -->

    @if (is_null($tomador->cnpj))
        <!-- Tomador Abertura de Empresa -->
        <div class="row pt-2">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <form>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Código do Cliente</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $tomador->codigo_cliente }}" disabled readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>CPF Responsável</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $tomador->cpf_responsavel }}" disabled readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="pb-3">Status:</p>
                                            @if ($tomador->status == 'ativo')
                                                <span class="status-ativo">Ativo</span>
                                            @elseif ($tomador->status == 'inativo')
                                                <span class="status-inativo">Inativo</span>
                                            @else
                                                <span class="status-pendente">Pendente</span>
                                            @endif
                                        </div>
                                    </div>
                                    

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nome Fantasia</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $tomador->nome_fantasia }}" disabled readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Razao Social 1</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $tomador->razao_social }}" disabled readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Razao Social 2</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $tomador->razao_social2 }}" disabled readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Razao Social 3</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $tomador->razao_social3 }}" disabled readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Email</label>
                                                <input type="text" class="form-control" value="{{ $tomador->email }}"
                                                    disabled readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Telefone</label>
                                                <input type="text" class="form-control" value="{{ $tomador->telefone }}"
                                                    disabled readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">CEP</label>
                                                <input type="text" class="form-control" value="{{ $tomador->cep }}"
                                                    disabled readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label for="">Estado</label>
                                                <input type="text" class="form-control" value="{{ $tomador->estado }}"
                                                    disabled readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Cidade</label>
                                                <input type="text" class="form-control" value="{{ $tomador->cidade }}"
                                                    disabled readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="">Bairro</label>
                                                <input type="text" class="form-control" value="{{ $tomador->bairro }}"
                                                    disabled readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label for="">Logradouro</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $tomador->logradouro }}" disabled readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Número</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $tomador->numero }}" disabled readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Complemento</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $tomador->complemento }}" disabled readonly>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Tomador Cliente Regular -->
        <div class="row pt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <form>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Código do Cliente</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $tomador->codigo_cliente }}" disabled readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>CNPJ</label>
                                                <input type="text" class="form-control" value="{{ $tomador->cnpj }}"
                                                    disabled readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Data de Abertura</label>
                                                <input type="date" class="form-control"
                                                    value="{{ $tomador->data_abertura }}" disabled readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="pb-3">Status:</p>
                                            @if ($tomador->status == 'ativo')
                                                <span class="status-ativo">Ativo</span>
                                            @elseif ($tomador->status == 'inativo')
                                                <span class="status-inativo">Inativo</span>
                                            @else
                                                <span class="status-pendente">Pendente</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row pt-2">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nome Fantasia</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $tomador->nome_fantasia }}" disabled readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Razao Social</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $tomador->razao_social }}" disabled readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Inscrição Estadual</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $tomador->inscricao_estadual }}" disabled readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Inscrição Municipal</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $tomador->inscricao_municipal }}" disabled readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Natureza Juridica</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $tomador->natureza_juridica }}" disabled readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Regime Tributario</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $tomador->regime_tributario }}" disabled readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Capital Social</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $tomador->capital_social }}" disabled readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">CNAE</label>
                                                <input type="text" class="form-control" value="{{ $tomador->cnae }}"
                                                    disabled readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Código Tributação</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $tomador->codigo_tributacao }}" disabled readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Email</label>
                                                <input type="text" class="form-control" value="{{ $tomador->email }}"
                                                    disabled readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Telefone</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $tomador->telefone }}" disabled readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">CEP</label>
                                                <input type="text" class="form-control" value="{{ $tomador->cep }}"
                                                    disabled readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label for="">Estado</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $tomador->estado }}" disabled readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Cidade</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $tomador->cidade }}" disabled readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="">Bairro</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $tomador->bairro }}" disabled readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label for="">Logradouro</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $tomador->logradouro }}" disabled readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Número</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $tomador->numero }}" disabled readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Complemento</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $tomador->complemento }}" disabled readonly>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="accordion" id="accordionExample" itemscope=""
                                                itemtype="https://schema.org/FAQPage">
                                                <div class="accordion-item" itemscope="" itemprop="mainEntity"
                                                    itemtype="https://schema.org/Question">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                            aria-expanded="true" aria-controls="collapseOne">
                                                            <b itemprop="name">Sócio(s)</b>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne" class="accordion-collapse collapse"
                                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                        <div itemscope="" itemprop="acceptedAnswer"
                                                            itemtype="https://schema.org/Answer">
                                                            <div class="accordion-body" itemprop="text">
                                                                @forelse ($socios as $socio)
                                                                    <!-- titulo -->
                                                                    <div
                                                                        class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                                                                        <div>
                                                                            <h4 class="line-title"><strong>Sócio</strong>
                                                                                <br /><small>{{ $socio->nome }}</small>
                                                                            </h4>
                                                                        </div>
                                                                        <!-- botao -->
                                                                        <div class="ms-md-auto py-2 py-md-0">
                                                                            <div class="btn-group" role="group"
                                                                                aria-label="Basic example">
                                                                                <a href="{{ route('empresas.tomador.sociosDocumentos', ['tomadorservico' => $tomador->id, 'socio' => $socio->id]) }}"
                                                                                    class="btn btn btn-secondary btn-sm"
                                                                                    title="Documentos">
                                                                                    <i
                                                                                        class="fa-solid fas fa-file-pdf btn-icon-append"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <!-- botao -->
                                                                    </div>
                                                                    <!-- tutulo -->

                                                                    <!-- socios -->
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <p>Nome:</p>
                                                                            <p class="fw-bold">{{ $socio->nome }}</p>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <p>Identidade:</p>
                                                                            <p class="fw-bold">{{ $socio->identidade }}
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <p>CPF:</p>
                                                                            <p class="fw-bold">{{ $socio->cpf }}</p>
                                                                        </div>
                                                                    </div>
                                                                    <hr />
                                                                    <div class="row">
                                                                        <div class="col-sm-3">
                                                                            <p>Profissão:</p>
                                                                            <p class="fw-bold">{{ $socio->profissao }}</p>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <p>Estado Civil:</p>
                                                                            <p class="fw-bold">{{ $socio->estado_civil }}
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <p>E-mail:</p>
                                                                            <p class="fw-bold">{{ $socio->email }}</p>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <p>Telefone:</p>
                                                                            <p class="fw-bold">{{ $socio->telefone }}</p>
                                                                        </div>
                                                                    </div>
                                                                    <hr />
                                                                    <div class="row">
                                                                        <div class="col-sm-2">
                                                                            <p>CEP:</p>
                                                                            <p class="fw-bold">{{ $socio->cep }}</p>
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            <p>Estado:</p>
                                                                            <p class="fw-bold">{{ $socio->estado }}</p>
                                                                        </div>
                                                                        <div class="col-sm-4">
                                                                            <p>Cidade:</p>
                                                                            <p class="fw-bold">{{ $socio->cidade }}</p>
                                                                        </div>
                                                                        <div class="col-sm-4">
                                                                            <p>Bairro:</p>
                                                                            <p class="fw-bold">{{ $socio->bairro }}</p>
                                                                        </div>
                                                                    </div>
                                                                    <hr />
                                                                    <div class="row pb-3">
                                                                        <div class="col-sm-8">
                                                                            <p>Logradouro:</p>
                                                                            <p class="fw-bold">{{ $socio->logradouro }}
                                                                            </p>
                                                                        </div>

                                                                        <div class="col-sm-4">
                                                                            <p>Complemento:</p>
                                                                            <p class="fw-bold">
                                                                                {{ $socio->complemento ?? 'N/A' }}</p>
                                                                        </div>
                                                                    </div>
                                                                    <hr />

                                                                @empty
                                                                    <!-- socios -->
                                                                    <div class="row">
                                                                        <div class="col-sm-8">
                                                                            <p class="fw-bold">Nenhum Sócio encontrado.</p>
                                                                        </div>
                                                                    </div>
                                                                @endforelse
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


@endsection
