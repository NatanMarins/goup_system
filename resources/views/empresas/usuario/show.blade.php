@extends('empresas.layout.admin')

@section('content')

    <x-alert />

    <!-- Cabeçalho -->
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2">
        <!-- botao -->
        <div class="ms-md-auto py-2 py-md-0">
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="{{ route('empresas.usuario.create') }}" class="btn btn-primary btn-sm" title="Cadastrar Usuário">
                    <i class="fa-solid fas fa-user-plus"></i>
                </a>
                <a href="{{ route('empresas.usuario.index') }}" class="btn btn-primary btn-sm" title="Listar Usuários">
                    <i class="fa-solid fa-list"></i>
                </a>
            </div>
        </div>
        <!-- botao -->
    </div>
    <!-- Cabeçalho -->


    <div class="container mt-2">
        <div class="row">
            <div class="col-md-4">
                <!-- Foto de Perfil -->
                <div class="card">
                    <div class="card-body text-center">

                        <img src="{{ $user->foto_perfil ? asset('storage/' . $user->foto_perfil) : asset('imagens/default-avatar.png') }}"
                            alt="Foto de perfil" width="183" height="183" class="rounded-circle img-fluid ">

                        <h4 class="mt-3">{{ $user->name }}</h4>

                        <p>{{ $empresa->nome }}</p>

                        <!-- Último Acesso -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover mt-3">
                                <tbody>
                                    <tr>
                                        <td>
                                            <strong>Último Acesso:</strong>
                                        </td>
                                        <td>
                                            @if ($user->last_login_at)
                                                {{ $user->last_login_at->diffForHumans() }}
                                            @else
                                                Nunca logado
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <!-- Informações do Usuário -->
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2">
                            <div>
                                <h4 class="fw-bold mb-3">Dados Usuário</h4>
                            </div>
                            <!-- botao -->
                            <div class="ms-md-auto py-2 py-md-0">
                                <div class="btn-group" role="group" aria-label="Basic example">

                                    <form action="{{ route('empresas.usuario.destroy', ['usuario' => $user->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-primary btn-sm" title="Excluir Usuário"
                                            onclick="return confirm('Deseja excluir usuário permanentemente?')"><i
                                                class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                            <!-- botao -->
                        </div>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Nome Completo</label>
                                    <input type="text" class="form-control" id="nome_completo"
                                        value="{{ $user->nome_completo }}"readonly>
                                </div>

                                <div class="form-group col-md-12">
                                    <label>CPF</label>
                                    <input type="text" class="form-control" id="cpf"
                                        value="{{ $user->cpf }}"readonly>
                                </div>

                                <div class="form-group col-md-12">
                                    <label>Data Nascimento</label>
                                    <input type="text" class="form-control" id="data_nascimento" value="{{ $dataFormatada }}"
                                        readonly>
                                </div>

                                <div class="form-group col-md-12">
                                    <label>Cardo</label>
                                    <input type="text" class="form-control" id="cargo" value="{{ $user->cargo }}"
                                        readonly>
                                </div>

                                <div class="form-group col-md-12">
                                    <label>E-mail</label>
                                    <input type="email" class="form-control" id="email" value="{{ $user->email }}"
                                        readonly>
                                </div>

                                <div class="form-group col-md-12">
                                    <label>Telefone</label>
                                    <input type="email" class="form-control" id="telefone" value="{{ $user->telefone }}"
                                        readonly>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
