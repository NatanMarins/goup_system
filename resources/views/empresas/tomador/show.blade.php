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
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h4><strong>Detalhes do Cliente</strong> <br /><small>{{ $tomador->nome_fantasia }}</small></h4>
        </div>
        <!-- botao -->
        <div class="ms-md-auto py-2 py-md-0">
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="#" class="btn btn btn-secondary btn-sm" title="Dados de Pagamento">
                    <i class="fa-solid fas fa-dollar-sign btn-icon-append"></i>
                </a>
                <a href="{{ route('empresas.tomador.documentos', ['tomadorservico' => $tomador->id]) }}"
                    class="btn btn btn-secondary btn-sm" title="Documentação">
                    <i class="fa-solid fas fa-file-pdf btn-icon-append"></i>
                </a>
            </div>
        </div>
        <!-- botao -->
    </div>
    <!-- Cabeçalho -->

    @if (is_null($tomador->cnpj))
        <!-- Tomador Abertura de Empresa -->
                <form>
                    <label>Código Cliente</label>
                    <input type="text" class="form-control" value="{{ $tomador->codigo_cliente }}" disabled readonly>

                    <label>Responsável</label>
                    <input type="text" class="form-control" value="{{ $tomador->responsavel }}" disabled readonly>

                    <label>CPF Responsável</label>
                    <input type="text" class="form-control" value="{{ $tomador->cpf_responsavel }}" disabled readonly>

                    <label for="">Razao Social 1</label>
                    <input type="text" class="form-control" value="{{ $tomador->razao_social }}" disabled readonly>

                    <label for="">Razao Social 2</label>
                    <input type="text" class="form-control" value="{{ $tomador->razao_social2 }}" disabled readonly>

                    <label for="">Razao Social 3</label>
                    <input type="text" class="form-control" value="{{ $tomador->razao_social3 }}" disabled readonly>

                    <label for="">Email</label>
                    <input type="text" class="form-control" value="{{ $tomador->email }}" disabled readonly>

                    <label for="">Telefone</label>
                    <input type="text" class="form-control" value="{{ $tomador->telefone }}" disabled readonly>

                    <label for="">CEP</label>
                    <input type="text" class="form-control" value="{{ $tomador->cep }}" disabled readonly>

                    <label for="">Estado</label>
                    <input type="text" class="form-control" value="{{ $tomador->estado }}" disabled readonly>

                    <label for="">Cidade</label>
                    <input type="text" class="form-control" value="{{ $tomador->cidade }}" disabled readonly>

                    <label for="">Bairro</label>
                    <input type="text" class="form-control" value="{{ $tomador->bairro }}" disabled readonly>

                    <label for="">Logradouro</label>
                    <input type="text" class="form-control" value="{{ $tomador->logradouro }}" disabled readonly>

                    <label for="">Número</label>
                    <input type="text" class="form-control" value="{{ $tomador->numero }}" disabled readonly>

                    <label for="">Complemento</label>
                    <input type="text" class="form-control" value="{{ $tomador->complemento }}" disabled readonly>
                </form>
            </div>
        </div>
    @else
        <!-- Tomador Cliente Regular -->
                <form>
                    <label>Código Cliente</label>
                    <input type="text" class="form-control" value="{{ $tomador->codigo_cliente }}" disabled readonly>

                    <label>Nome Fantasia</label>
                    <input type="text" class="form-control" value="{{ $tomador->nome_fantasia }}" disabled readonly>

                    <label for="">Razao Social</label>
                    <input type="text" class="form-control" value="{{ $tomador->razao_social }}" disabled readonly>

                    <label for="">CNPJ</label>
                    <input type="text" class="form-control" value="{{ $tomador->cnpj }}" disabled readonly>

                    <label for="">Inscrição Estadual</label>
                    <input type="text" class="form-control" value="{{ $tomador->inscricao_estadual }}" disabled
                        readonly>

                    <label for="">Inscrição Municipal</label>
                    <input type="text" class="form-control" value="{{ $tomador->inscricao_municipal }}" disabled
                        readonly>

                    <label for="">Natureza Juridica</label>
                    <input type="text" class="form-control" value="{{ $tomador->natureza_juridica }}" disabled
                        readonly>

                    <label for="">Regime Tributario</label>
                    <input type="text" class="form-control" value="{{ $tomador->regime_tributario }}" disabled
                        readonly>

                    <label for="">Capital Social</label>
                    <input type="text" class="form-control" value="{{ $tomador->capital_social }}" disabled readonly>

                    <label for="">CNAE</label>
                    <input type="text" class="form-control" value="{{ $tomador->cnae }}" disabled readonly>

                    <label for="">Data Abertura</label>
                    <input type="date" class="form-control" value="{{ $tomador->data_abertura }}" disabled readonly>

                    <label for="">Código Tributação</label>
                    <input type="text" class="form-control" value="{{ $tomador->codigo_tributacao }}" disabled
                        readonly>

                    <label for="">Email</label>
                    <input type="text" class="form-control" value="{{ $tomador->email }}" disabled readonly>

                    <label for="">Telefone</label>
                    <input type="text" class="form-control" value="{{ $tomador->telefone }}" disabled readonly>

                    <label for="">CEP</label>
                    <input type="text" class="form-control" value="{{ $tomador->cep }}" disabled readonly>

                    <label for="">Estado</label>
                    <input type="text" class="form-control" value="{{ $tomador->estado }}" disabled readonly>

                    <label for="">Cidade</label>
                    <input type="text" class="form-control" value="{{ $tomador->cidade }}" disabled readonly>

                    <label for="">Bairro</label>
                    <input type="text" class="form-control" value="{{ $tomador->bairro }}" disabled readonly>

                    <label for="">Logradouro</label>
                    <input type="text" class="form-control" value="{{ $tomador->logradouro }}" disabled readonly>

                    <label for="">Número</label>
                    <input type="text" class="form-control" value="{{ $tomador->numero }}" disabled readonly>

                    <label for="">Complemento</label>
                    <input type="text" class="form-control" value="{{ $tomador->complemento }}" disabled readonly>
                </form>
            </div>

            <div class="row">
                <div class="col-sm-8">
                    <p>Email:</p>
                    <p class="fw-bold">{{ $tomador->email }}</p>
                </div>
                <div class="col-sm-4">
                    <p>Status:</p>
                    @if ($tomador->status == 'ativo')
                        <span class="status-ativo">Ativo</span>
                    @elseif ($tomador->status == 'inativo')
                        <span class="status-inativo">Inativo</span>
                    @else
                        <span class="status-pendente">Pendente</span>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <div class="accordion" id="accordionExample" itemscope="" itemtype="https://schema.org/FAQPage">
        <div class="accordion-item" itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">
                    <b itemprop="name">Sócio(s)</b>
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                data-bs-parent="#accordionExample">
                <div itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <div class="accordion-body" itemprop="text">
                        @forelse ($socios as $socio)
                            <!-- titulo -->
                            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                                <div>
                                    <h4 class="line-title"><strong>Sócio</strong> <br /><small>{{ $socio->nome }}</small>
                                    </h4>
                                </div>
                                <!-- botao -->
                                <div class="ms-md-auto py-2 py-md-0">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('empresas.tomador.sociosDocumentos', ['tomadorservico' => $tomador->id, 'socio' => $socio->id]) }}"
                                            class="btn btn btn-secondary btn-sm" title="Documentos">
                                            <i class="fa-solid fas fa-file-pdf btn-icon-append"></i>
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
                                    <p class="fw-bold">{{ $socio->identidade }}</p>
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
                                    <p class="fw-bold">{{ $socio->estado_civil }}</p>
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
                                    <p class="fw-bold">{{ $socio->logradouro }}</p>
                                </div>

                                <div class="col-sm-4">
                                    <p>Complemento:</p>
                                    <p class="fw-bold">{{ $socio->complemento ?? 'N/A' }}</p>
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
@endsection
