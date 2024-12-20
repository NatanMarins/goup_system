@extends('tomadores.layout.admin')

@section('content')

<!-- Cabeçalho -->
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2">
    <div>
        <h4 class="fw-bold">Clientes</h4>
    </div>
    <!-- botao -->
    <div class="ms-md-auto py-2 py-md-0">
        <div class="btn-group" role="group" aria-label="Basic example">
            <a href="{{ route('tomadores.clientes.createCpf') }}" class="btn btn btn-secondary btn-sm" title="Cliente CPF">
                <i class="fa-solid fa-plus"></i> CPF
            </a>
            <a href="{{ route('tomadores.clientes.createCnpj') }}" class="btn btn btn-secondary btn-sm" title="Cliente CNPJ">
                <i class="fa-solid fa-plus"></i> CNPJ
            </a>
        </div>
    </div>
    <!-- botao -->
</div>
<!-- Cabeçalho -->

<!-- COnteudo -->
<div class="row">
    <div class="col-md-12">
        <!--Inserir o COnteudo da página -->
        <!--tabela -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover mt-3 table-light ">
                <thead class="table-dark">
                    <tr>
                        <th class="ms-5">ID</th>
                        <th>Cliente</th>
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
                                    
                                    @if (is_null($cliente->cnpj))
                                        <!-- Link para editCnpj -->
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="{{ route('tomadores.clientes.editCpf', $cliente->id) }}" class="btn btn btn-secondary btn-sm" title="Editar Cliente">
                                                <i class="fa-solid fa-edit btn-icon-append"></i>
                                            </a>
                                            <a href="{{ route('tomadores.clientes.showCpf', $cliente->id) }}" class="btn btn btn-secondary btn-sm" title="Editar Cliente">
                                                <i class="fa-solid fa-eye btn-icon-append"></i>
                                            </a>
                                        </div>
                                    @else
                                        <!-- Link para editCpf -->
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="{{ route('tomadores.clientes.editCnpj', $cliente->id) }}" class="btn btn btn-secondary btn-sm" title="Visualizar Cliente">
                                                <i class="fa-solid fa-edit btn-icon-append"></i>
                                            </a>
                                            <a href="{{ route('tomadores.clientes.showCnpj', $cliente->id) }}" class="btn btn btn-secondary btn-sm" title="Visualizar Cliente">
                                                <i class="fa-solid fa-eye btn-icon-append"></i>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <p>Nenhum Cliente Encontrado</p>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!--tabela -->
    </div>
</div>
@endsection
