@extends('empresas.layout.admin')

@section('content')
    <x-alert />

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <!-- Foto de Perfil -->
                <div class="card">
                    <div class="card-body text-center">

                        <!-- Último Acesso -->
                        <p class="small">
                            Último Acesso:
                            @if (Auth::user()->last_login_at)
                                {{ Auth::user()->last_login_at->diffForHumans() }}
                            @else
                                Nunca logado
                            @endif
                        </p>

                        <img src="{{ $user->foto_perfil ? asset('storage/' . $user->foto_perfil) : asset('imagens/default-avatar.png') }}"
                            alt="Foto de perfil" width="150" height="150" class="rounded-circle img-fluid">


                        <h4 class="mt-3">{{ Auth::user()->name }}</h4>

                        <p>{{ $empresa->nome }}</p>

                        <!-- Botão para alterar a foto de perfil -->
                        <!-- Botão que abre o modal -->
                        <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal"
                            data-bs-target="#editProfilePhotoModal">
                            Alterar Foto de Perfil
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <!-- Informações do Usuário -->
                <div class="card">
                    <div class="card-header">
                        <h4>Minhas Informações</h4>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="name" value="{{ Auth::user()->name }}"
                                    readonly>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email" value="{{ Auth::user()->email }}"
                                    readonly>
                            </div>
                        </form>
                        <div class="mb-3">
                            <!-- Botão que abre o modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#editProfileModal">
                                Editar Cadastro
                            </button>
                            <!-- Botão que abre o modal de alteração de senha -->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#changePasswordModal">
                                Alterar Senha
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Alterar Foto de Perfil -->
    <div class="modal fade" id="editProfilePhotoModal" tabindex="-1" aria-labelledby="editProfilePhotoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfilePhotoModalLabel">Alterar Foto de Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('empresas.profile.update-foto') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="foto_perfil" class="form-label">Escolha uma nova foto de perfil</label>
                            <input type="file" class="form-control" name="foto_perfil" id="foto_perfil" accept="image/*">
                        </div>
                        <div class="text-center">
                            <small class="text-muted">Apenas formatos de imagem: JPG, JPEG, PNG. Tamanho máximo:
                                2MB.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para edição de perfil -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Editar Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('empresas.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" name="name" id="name"
                                value="{{ Auth::user()->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" name="email" id="email"
                                value="{{ Auth::user()->email }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para alteração de senha -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Alterar Senha</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('empresas.profile.update-password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <!-- Campos do formulário -->
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Senha Atual</label>
                            <input type="password" class="form-control" name="current_password" id="current_password"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Nova Senha</label>
                            <input type="password" class="form-control" name="new_password" id="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirme a Nova Senha</label>
                            <input type="password" class="form-control" name="new_password_confirmation"
                                id="new_password_confirmation" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Alterar Senha</button>
                    </div>
                </form>
            </div>
        </div>
        @if ($errors->any())
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var modal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
                    modal.show();
                });
            </script>
        @endif
    </div>
@endsection
