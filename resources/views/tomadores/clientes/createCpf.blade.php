@extends('tomadores.layout.admin')

@section('content')

<!-- Cabeçalho -->
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2">
    <div>
        <h4 class="fw-bold">Cadastrar Novo Cliente | CPF</h4>
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
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">

                            <x-alert />

                            <!--Inserir o COnteudo da página -->
                            <form class="forms-sample" action="{{ route('tomadores.clientes.storeCpf') }}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <h4> Informações Pessoais </h4>
                                        <hr />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nome</label>
                                            <input type="text" name="nome" id="nome" value="{{ old('nome') }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Sobrenome</label>
                                            <input type="text" name="sobrenome" id="sobrenome"
                                                value="{{ old('sobrenome') }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>CPF</label>
                                            <input type="text" name="cpf" id="cpf" value="{{ old('cpf') }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <h4> Contato </h4>
                                        <hr />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Telefone</label>
                                            <input type="text" name="telefone" id="telefone"
                                                value="{{ old('telefone') }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>E-mail</label>
                                            <input type="text" name="email" id="email" value="{{ old('email') }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Site</label>
                                            <input type="text" name="site" id="site" value="{{ old('site') }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row pt-4">
                                    <div class="col-md-12">
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-secondary">Cadastrar</button>
                                            <button type="reset" class="btn btn-secondary">Cancelar</button>
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
@endsection
