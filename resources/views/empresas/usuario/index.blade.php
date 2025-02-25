@extends('empresas.layout.admin')

@section('content')

 <!-- Cabeçalho -->
 <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h4><strong>Usuários</strong> <br /><small>{{ $empresa->nome }}</small></h4>
    </div>
    <!-- botao -->
    <div class="ms-md-auto py-2 py-md-0">
        <div class="btn-group" role="group" aria-label="Basic example">
            <a href="{{ route('empresas.usuario.create') }}" class="btn btn-primary btn-sm" title="Cadastrar Usuário">
                <i class="fas fa-user-plus fa-plus"></i>
            </a>
        </div>
    </div>
    <!-- botao -->
</div>
<!-- Cabeçalho -->

    @if ($usuarios->isEmpty())
        <div class="alert alert-warning" role="alert">
            <p>Nenhum Usuário Encontrado!</p>
        </div>
    @else
        <!-- COnteudo -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <!-- se precisar de topo no card
                        <div class="card-header">
                            <div class="card-title">Listar Produtos</div>
                        </div>
                        se precisar de topo no card -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <!--Inserir o COnteudo da página -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead class="table-success">
                                            <tr>
                                                <th scope="col" style="width:5%"></th>
                                                <th scope="col">Cliente</th>
                                                <th scope="col">E-mail</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($usuarios as $usuario)
                                                <tr>
                                                    <td style="width:200px" class="text-center">
                                                        @if ($usuario->foto_perfil)
                                                            <div class="colaborador-image">
                                                                <img src="{{ asset('storage/' . $usuario->foto_perfil) }}"
                                                                    alt="Imagem Perfil do Usuário" style="max-width: 70px;">
                                                            </div>
                                                        @else
                                                            <div class="colaborador-image">
                                                                <img src="{{ asset('imagens/default-avatar.png') }}"
                                                                    alt="Imagem Perfil do Usuário" style="max-width: 70px;">
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>{{ $usuario->name }}</td>
                                                    <td>{{ $usuario->email }}</td>

                                                    <td class="text-center" style="width:5%">
                                                        <div class="btn-group" role="group" aria-label="Basic example">
                                                            <a href="{{ route('empresas.usuario.show', ['usuario' => $usuario->id]) }}" class="btn btn btn-primary btn-sm" title="Visualizar Usuário">
                                                                <i class="fa-solid fa-eye btn-icon-append"></i>
                                                            </a>
                                                        </div>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
