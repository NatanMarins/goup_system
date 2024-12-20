@extends('empresas.layout.admin')

@section('content')

    <x-alert />

<!-- Cabeçalho -->
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h4 class="fw-bold mb-3">Editar Senha</4> 
    </div>

</div>
<!-- Cabeçalho -->

<div class="row justify-content-md-center">
    <div class="col col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('empresas.usuario.update-password', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
            
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="senha_atual">Senha Atual</label>
                            <input type="password" name="senha_atual" id="senha_atual" class="form-control">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="password" class="form-label">Nova Senha</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                    </div>
                    
                    <div class="row pt-4">
                        <div class="col-md-12">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                            </div>
                        </div>
                    </div>
                                        
                </form>
            </div>
        </div>
    </div>
</div>



@endsection