@extends('tomadores.layout.admin')

@section('content')


<!-- Cabeçalho -->
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h4 class="fw-bold">Editar - {{ $dadosCliente->nome }}</h4>
    </div>
</div>
<!-- Cabeçalho -->


<!-- COnteudo -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!--Inserir o COnteudo da página -->
                <x-alert />
                <form class="forms-sample" action="{{ route('tomadores.clientes.updateCpf', $dadosCliente->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nome</label>
                                <input type="text" name="nome" id="nome" value="{{ old('nome', $dadosCliente->nome) }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Sobrenome</label>
                                <input type="text" name="sobrenome" id="sobrenome" value="{{ old('sobrenome', $dadosCliente->sobrenome) }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>CPF</label>
                                <input type="text" name="cpf" id="cpf" value="{{ old('cpf', $dadosCliente->cpf) }}"  class="form-control">
                            </div>
                        </div>
                   
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Telefone</label>
                                <input type="text" name="telefone" id="telefone"  value="{{ old('telefone', $dadosCliente->telefone) }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>E-mail</label>
                                <input type="text" name="email" id="email" value="{{ old('email', $dadosCliente->email) }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Site</label>
                                <input type="text" name="site" id="site" value="{{ old('site', $dadosCliente->site) }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="col-md-12">
                            <div class="text-center">
                                <button type="submit" class="btn btn-secondary">Editar</button>
                                <button type="reset" class="btn btn-secondary">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
