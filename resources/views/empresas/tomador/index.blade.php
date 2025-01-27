@extends('empresas.layout.admin')

@section('content')

    <x-alert />

    <!-- Cabeçalho -->
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h4 class="fw-bold">Lista de Tomadores de Serviço</h4>
        </div>
    </div>
    <!-- Cabeçalho -->
    <div class="row pt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <form action="{{ route('empresas.tomador.index') }}" method="GET" class="mb-4">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <!-- Filtro por Status -->
                                            <label>Status</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="">Todos</option>
                                                <option value="ativo" {{ request('status') == 'ativo' ? 'selected' : '' }}>Ativo</option>
                                                <option value="inativo" {{ request('status') == 'inativo' ? 'selected' : '' }}>Inativo</option>
                                                <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <!-- Filtro por Condição -->
                                            <label>Condição</label>
                                            <select name="condicao" id="condicao" class="form-control">
                                                <option value="">Todas</option>
                                                <option value="cliente_regular" {{ request('condicao') == 'cliente regular' ? 'selected' : '' }}>Cliente Regular</option>
                                                <option value="abertura_de_empresa" {{ request('condicao') == 'abertura de empresa' ? 'selected' : '' }}>Abertura de Empresa</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <!-- Filtro por Situação -->
                                            <label>Situação</label>
                                            <select name="situacao" id="situacao" class="form-control">
                                                <option value="">Todas</option>
                                                <option value="inadimplente" {{ request('situacao') == 'inadimplente' ? 'selected' : '' }}>Inadimplente</option>
                                                <option value="adimplente" {{ request('situacao') == 'adimplente' ? 'selected' : '' }}>Adimplente</option>
                                                <option value="abandono_de_carrinho" {{ request('situacao') == 'abandono de carrinho' ? 'selected' : '' }}>Abandono de Carrinho</option>
                                                <option value="pendente" {{ request('situacao') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <!-- Campo de Busca -->
                                            <label>Nome</label>
                                            <input type="text" name="nome" id="nome" class="form-control" value="{{ request('nome') }}"  placeholder="Digite o nome">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Botão de Buscar -->
                                    <div class="col-md-12 mt-3 text-center">
                                        <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
                                        <a href="{{ route('empresas.tomador.index') }}" class="btn btn-primary btn-sm">Limpar Filtros</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>        
        
    <div class="row pt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
            
                            <!--tabela -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-success">
                                        <tr>
                                            <th class="ms-5">Nome Fantasia</th>
                                            <th>E-mail</th>
                                            <th class="text-center">Situação</th>
                                            <th>Condição</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($clientes as $cliente)
                                            @if ($cliente->situacao === 'inadimplente')
                                                <tr>
                                                    <td>{{ $cliente->nome_fantasia }}</td>
                                                    <td>{{ $cliente->email }}</td>
                                                    <td class="text-center"><i class='fa-solid fas fa-circle-exclamation'
                                                            style='font-size:20px; color:#C42F02;'></i></td>
                                                    <td>{{ $cliente->condicao }}</td>
                                                    <td class="text-center">
                                                        <div class="btn-group" role="group" aria-label="Basic example">
                                                            <a href="{{ route('empresas.tomador.show', $cliente->id) }}"
                                                                class="btn btn btn-primary btn-sm" title="Visualizar">
                                                                <i class="fa-solid fa-eye btn-icon-append"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td>{{ $cliente->nome_fantasia }}</td>
                                                    <td>{{ $cliente->email }}</td>
                                                    <td class="text-center"><i class='fa-solid fas fa-circle-check'
                                                            style='font-size:20px; color:#01c592;'></i></td>
                                                    <td>{{ $cliente->condicao }}</td>
                                                    <td class="text-center">
                                                        <div class="btn-group" role="group" aria-label="Basic example">
                                                            <a href="{{ route('empresas.tomador.show', $cliente->id) }}"
                                                                class="btn btn btn-primary btn-sm" title="Visualizar">
                                                                <i class="fa-solid fa-eye btn-icon-append"></i>
                                                            </a>
                                                            <a href="{{ route('empresas.tomador.edit', $cliente->id) }}"
                                                                class="btn btn btn-primary btn-sm" title="editar">
                                                                <i class="fa-solid fa-pen-to-square btn-icon-append"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif

                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Nenhum tomador encontrado.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!--tabela -->
                        </div>
                    </div>

                    <!-- Paginação -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Paginação -->
                            {{ $clientes->links() }}
                        </div>
                    </div>
                    <!-- Paginação -->
                </div>
            </div>
        </div>
    </div>
            
            
@endsection
