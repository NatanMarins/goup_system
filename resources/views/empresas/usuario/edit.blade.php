@extends('empresas.layout.admin')

@section('content')

<!-- Cabeçalho -->
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2">
    <div>
        <h4><strong>Editar Usuário</strong> <br /><small></small></h4>
    </div>
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
    
<x-alert />
<!-- COnteudo -->
    <div class="row pt-3">
        <div class="col col-lg-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('empresas.usuario.update', ['usuario' => $usuario->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Nome</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $usuario->name) }}" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label>E-mail</label>
                                <input type="text" name="email" id="email" value="{{ old('email', $usuario->email) }}" class="form-control">
                            </div>
                        </div>

                        <div class="row pt-4">
                            <div class="col-md-12">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-sm">Editar</button>
                                    <button type="reset" class="btn btn-primary btn-sm">Cancelar</button>
                                </div>
                            </div>
                        </div>
                                                        
                    </form>
                       
                <!--Inserir o COnteudo da página -->
                </div>
            </div>
        </div>
    </div>


@endsection
<!-- COnteudo -->