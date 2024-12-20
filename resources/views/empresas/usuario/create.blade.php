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
                            <label>Nome: </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control">
                        </div>

                        <div class="form-group col-md-6">
                            <label>E-mail: </label>
                            <input type="text" name="email" id="email" value="{{ old('name') }}" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Senha: </label>
                            <input type="password" name="password" id="password" value="{{ old('name') }}" class="form-control">
                        </div>
                    </div>
                    
                    <div class="row pt-4">
                        <div class="col-md-12">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-sm">Cadastrar</button>
                                <button type="reset" class="btn btn-primary btn-sm">Cancelar</button>
                            </div>
                        </div>
                    </div>
                                        
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
