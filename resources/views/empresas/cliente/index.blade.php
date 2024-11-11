@extends('empresas.layout.admin')

@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <!-- topo da página -->
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center py-2">
                            <h1 class="card-title mb-2 mb-md-0">Clientes</h1>
                            <a href="{{ route('empresas.cliente.create') }}"
                                class="btn btn-inverse-info btn-sm"title="Cadastrar Nova Holding">
                                <i class="fa-solid fa-plus btn-icon-prepend"></i>
                                Novo Clinte
                            </a>
                        </div>
                    </div>
                </div>
                <!-- topo da página -->

                <div class="row">
                    <div class="col-md-12">
                        <!--tabela -->
                        <div class="table-responsive pt-3">
                            <table class="table table-striped project-orders-table table-hover">
                                <thead>
                                    <tr>
                                        <th class="ms-5">ID</th>
                                        <th>Nome</th>
                                        <th>CNPJ</th>
                                        <th>Endereço</th>
                                        <th>Telefone</th>
                                        <th style="width: 100px;">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($clientes as $cliente)
                                        <tr>
                                            <td>{{ $cliente->id }}</td>
                                            <td>{{ $cliente->nome }}</td>
                                            <td>{{ $cliente->cnpj }}</td>
                                            <td>{{ $cliente->endereco }}</td>
                                            <td>{{ $cliente->telefone }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <a href="{{ route('empresas.cliente.edit', $cliente->id) }}"
                                                        class="btn btn-inverse-info btn-sm btn-icon-text me-3"
                                                        title="Editar clientes">
                                                        <i class="fa-solid fa-edit btn-icon-append"></i>
                                                    </a>
                                                    <a href="{{ route('empresas.cliente.show', $cliente->id) }}"
                                                        class="btn btn-inverse-info btn-sm btn-icon-text  me-3"
                                                        title="Detalhes">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                    @empty
                                        <p>Nenhum cliente Encontrado</p>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!--tabela -->

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
