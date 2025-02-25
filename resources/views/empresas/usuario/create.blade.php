@extends('empresas.layout.admin')

@section('content')
    <!-- Cabeçalho -->
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h4 class="fw-bold mb-3">Cadastrar Novo Usuário</4>
        </div>
        <!-- botao -->
        <div class="ms-md-auto py-2 py-md-0">
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="{{ route('empresas.usuario.index') }}" class="btn btn-primary btn-sm" title="Listar Usuários">
                    <i class="fa-solid fa-list"></i>
                </a>
            </div>
        </div>
        <!-- botao -->
    </div>
    <!-- Cabeçalho -->

    <x-alert />

    <div class="row justify-content-md-center">
        <div class="col col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('empresas.usuario.store') }}" method="POST">
                        @csrf
                        @method('POST')

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Nome de Usuário: </label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Nome Completo: </label>
                                <input type="text" name="nome_completo" id="nome_completo"
                                    value="{{ old('nome_completo') }}" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>CPF: </label>
                                <input type="text" name="cpf" id="cpf" value="{{ old('cpf') }}"
                                    class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Data Nascimento: </label>
                                <input type="date" name="data_nascimento" id="data_nascimento"
                                    value="{{ old('data_nascimento') }}" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Cargo: </label>
                                <input type="text" name="cargo" id="cargo" value="{{ old('cargo') }}"
                                    class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label>telefone </label>
                                <input type="telefone" name="telefone" id="telefone" value="{{ old('telefone') }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>E-mail: </label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Senha: </label>
                                <input type="password" name="password" id="password" value="{{ old('password') }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="row pt-4">
                            <div class="col-md-12">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-sm">Cadastrar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
