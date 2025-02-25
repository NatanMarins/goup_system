@extends('empresas.layout.admin')

@section('content')

<x-alert />

 <!-- Cabeçalho -->
 <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h4 class="fw-bold">Perfil {{ $empresa->nome }}</h4>
    </div>
</div>
<!-- Cabeçalho -->

<div class="row pt-2">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
    
                        <h4>Informações {{ $empresa->nome }}</h4>
                        <hr />
                    
                        <form>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nome Fantasia</label>
                                        <input type="text" class="form-control" value="{{ $empresa->nome_fantasia }}" disabled readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Razao Social</label>
                                        <input type="text" class="form-control" value="{{ $empresa->razao_social }}" disabled readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">CNPJ</label>
                                        <input type="text" class="form-control" value="{{ $empresa->cnpj }}" disabled readonly>  
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="text" class="form-control" value="{{ $empresa->email }}" disabled readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Telefone</label>
                                        <input type="text" class="form-control" value="{{ $empresa->telefone }}" disabled readonly>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">CEP</label>
                                        <input type="text" class="form-control" value="{{ $empresa->cep }}" disabled readonly>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="">Logradouro</label>
                                        <input type="text" class="form-control" value="{{ $empresa->logradouro }}" disabled readonly>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">Número</label>
                                        <input type="text" class="form-control" value="{{ $empresa->numero }}" disabled readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Bairro</label>
                                        <input type="text" class="form-control" value="{{ $empresa->bairro }}" disabled readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Cidade</label>
                                        <input type="text" class="form-control" value="{{ $empresa->cidade }}" disabled readonly>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">Estado</label>
                                        <input type="text" class="form-control" value="{{ $empresa->estado }}" disabled readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Complemento</label>
                                        <input type="text" class="form-control" value="{{ $empresa->complemento }}" disabled readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Botão  -->
                                <div class="col-md-12 mt-3 text-center">
                                    <a href="{{ route('empresas.empresa_profile.edit') }}">
                                        <button class="btn btn-primary">Editar Dados</button>
                                    </a>
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
