@extends('tomadores.layout.admin')

@section('content')

<!-- Cabeçalho -->
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h4 class="fw-bold">Detalhes do {{ $dadosCliente->nome . ' ' . $dadosCliente->sobrenome }}</h4>
    </div>
</div>
<!-- Cabeçalho -->

<!-- COnteudo -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                                       
                <!--Inserir o COnteudo da página -->
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nome">Nome:</label>
                                <input type="text" id="nome" class="form-control" value="{{ $dadosCliente->nome }}" readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sobrenome">Sobrenome:</label>
                                <input type="text" id="sobrenome" class="form-control" value="{{ $dadosCliente->sobrenome }}" readonly>
                            </div>
                        </div>
            
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cpf">CPF:</label>
                                <input type="text" id="cpf" class="form-control" value="{{ $dadosCliente->cpf }}" readonly>
                            </div>
                        </div>
        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telefone">Telefone:</label>
                                <input type="text" id="telefone" class="form-control" value="{{ $dadosCliente->telefone }}" readonly>
                            </div>
                        </div>
        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" id="email" class="form-control" value="{{ $dadosCliente->email }}" readonly>
                            </div>
                        </div>
        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="site">Site:</label>
                                <input type="url" id="site" class="form-control" value="{{ $dadosCliente->site }}" readonly>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row pt-4">
                    <div class="col-md-12">
                        <div class="text-center">
                            <a href="#" class="btn btn-secondary">Gerar Nota Fiscal</a>
                        </div>
                    </div>
                </div>
                    
                <!--Inserir o COnteudo da página -->
                         
            </div>
        </div>
    </div>
</div>
@endsection
