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

    <div class="row">
        <div class="col-sm-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <p>Razão Social:</p>
                            <p class="fw-bold">{{ $tomador->razao_social }}</p>
                        </div>
                        <div class="col-sm-6">
                            <p>Nome Fantasia:</p>
                            <p class="fw-bold">{{ $tomador->nome_fantasia }}</p>
                        </div>
                    </div>
                    <hr />

                    <div class="row">
                        <div class="col-sm-4">
                            <p>CNPJ:</p>
                            <p class="fw-bold">{{ $tomador->cnpj }}</p>
                        </div>
                        <div class="col-sm-4">
                            <p>Inscrição Municipal:</p>
                            <p class="fw-bold"> {{ $tomador->inscricao_municipal }}</p>
                        </div>
                        <div class="col-sm-4">
                            <p>Inscrição Estadual:</p>
                            <p class="fw-bold">{{ $tomador->inscricao_estadual }}</p>
                        </div>
                    </div>
                    <hr />

                    <div class="row">
                        <div class="col-sm-8">
                            <p>Endereço:</p>
                            <p class="fw-bold"> {{ $tomador->inscricao_municipal }}</p>
                        </div>
                        <div class="col-sm-4">
                            <p>Complemento:</small><br />
                            <p class="fw-bold">{{ $tomador->complemento ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-sm-8">
                            <p>Email:</p>
                            <p class="fw-bold">{{ $tomador->email }}</p>
                        </div>
                        <div class="col-sm-4">
                            <p>Status:</p>
                            @if ($tomador->status == 'ativo')
                                <span class="status-ativo">Ativo</span>
                            @else
                                <span class="status-inativo">Inativo</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="accordion" id="accordionExample" itemscope="" itemtype="https://schema.org/FAQPage">
        <div class="accordion-item" itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <b itemprop="name">Sócio(s)</b>
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <div class="accordion-body" itemprop="text">
                        @forelse ($socios as $socio)
                        
                            <!-- titulo -->
                            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                                <div>
                                    <h4 class="line-title"><strong>Sócio</strong> <br /><small>{{ $socio->nome }}</small></h4>
                                </div>
                                <!-- botao -->
                                <div class="ms-md-auto py-2 py-md-0">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('empresas.tomador.sociosDocumentos', ['tomadorservico' => $tomador->id, 'socio' => $socio->id]) }}" class="btn btn btn-secondary btn-sm" title="Documentos">
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
