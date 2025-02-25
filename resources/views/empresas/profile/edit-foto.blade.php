@extends('empresas.layout.admin')

@section('content')
    <x-alert />
    
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h4 class="fw-bold">Editar Foto Perfil </h4>
        </div>
    </div>

    <form action="{{ route('empresas.profile.update-foto') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Exibir a foto de perfil ou uma imagem genérica -->
        <div>
            <img src="{{ $user->foto_perfil ? asset('storage/' . $user->foto_perfil) : asset('imagens/default-avatar.png') }}"
                alt="Foto de perfil" width="150" height="150">
        </div>

        <!-- Campo para upload da foto -->
        <div class="form-group">
            <label for="foto_perfil">Alterar foto de perfil:</label>
            <input type="file" class="form-control" name="foto_perfil" id="foto_perfil">
        </div>

        <button type="submit" class="btn btn-primary">Atualizar Foto</button>
    </form>
@endsection
