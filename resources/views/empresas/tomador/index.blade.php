@extends('empresas.layout.admin')

@section('content')
    <!-- Cabeçalho -->
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h4 class="fw-bold">Lista de Tomadores de Serviço</h4>
        </div>
    </div>
    <!-- Cabeçalho -->

    <form action="{{ route('empresas.tomador.index') }}" method="GET" class="mb-4">
        <div class="row">
            <!-- Filtro por Status -->
            <div class="col-md-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="">Todos</option>
                    <option value="ativo" {{ request('status') == 'ativo' ? 'selected' : '' }}>Ativo</option>
                    <option value="inativo" {{ request('status') == 'inativo' ? 'selected' : '' }}>Inativo</option>
                    <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                </select>
            </div>

            <!-- Filtro por Condição -->
            <div class="col-md-3">
                <label for="condicao" class="form-label">Condição</label>
                <select name="condicao" id="condicao" class="form-control">
                    <option value="">Todas</option>
                    <option value="cliente_regular" {{ request('condicao') == 'cliente regular' ? 'selected' : '' }}>Cliente Regular</option>
                    <option value="abertura_de_empresa" {{ request('condicao') == 'abertura de empresa' ? 'selected' : '' }}>Abertura de Empresa</option>
                </select>
            </div>

            <!-- Filtro por Situação -->
            <div class="col-md-3">
                <label for="situacao" class="form-label">Situação</label>
                <select name="situacao" id="situacao" class="form-control">
                    <option value="">Todas</option>
                    <option value="inadimplente" {{ request('situacao') == 'inadimplente' ? 'selected' : '' }}>Inadimplente</option>
                    <option value="adimplente" {{ request('situacao') == 'adimplente' ? 'selected' : '' }}>Adimplente</option>
                    <option value="abandono_de_carrinho" {{ request('situacao') == 'abandono de carrinho' ? 'selected' : '' }}>Abandono de Carrinho</option>
                    <option value="pendente" {{ request('situacao') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                </select>
            </div>

            <!-- Campo de Busca -->
            <div class="col-md-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control" value="{{ request('nome') }}"
                    placeholder="Digite o nome">
            </div>

            <!-- Botão de Buscar -->
            <div class="col-md-12 mt-3">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="{{ route('empresas.tomador.index') }}" class="btn btn-secondary">Limpar Filtros</a>
            </div>
        </div>
    </form>



    <!-- COnteudo -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <!--Inserir o COnteudo da página -->
                    <!-- COnteudo -->

                </div>
                <!-- COnteudo -->

                <!-- COnteudo -->
                <div class="row">
                    <div class="col-md-12">
                        <!--Inserir o COnteudo da página -->
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
                    </div>
                </div>
                <!-- COnteudo -->

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
    <!-- COnteudo -->
@endsection
