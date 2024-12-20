@extends('tomadores.layout.admin')

@section('content')
  
<!-- Cabeçalho -->
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2">
    <div>
        <h4 class="fw-bold">Cadastrar Novo Cliente | CNPJ</h4>
    </div>
    <!-- botao -->
    <div class="ms-md-auto py-2 py-md-0">
        <div class="btn-group" role="group" aria-label="Basic example">
            <a href="{{ route('tomadores.clientes.createCpf') }}" class="btn btn btn-secondary btn-sm" title="Cliente CPF">
                <i class="fa-solid fa-plus"></i> CPF
            </a>
        </div>
    </div>
    <!-- botao -->
</div>
<!-- Cabeçalho -->

    <!-- COnteudo -->
    <div class="row pt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">

                            <x-alert />

                            <!--Inserir o COnteudo da página -->
                            <form class="forms-sample" action="{{ route('tomadores.clientes.storeCnpj') }}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <h4> Informações da Empresa </h4>
                                        <hr />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Nome Fanatasia</label>
                                            <input type="text" name="nome" id="nome" value="{{ old('nome') }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Razão Social</label>
                                            <input type="text" name="razao_social" id="razao_social"
                                                value="{{ old('razao_social') }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>CNPJ</label>
                                            <input type="text" name="cnpj" id="cnpj" value="{{ old('cnpj') }}"
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
                            <!--Inserir o COnteudo da página -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
