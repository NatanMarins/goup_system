@extends('empresas.layout.admin')

@section('content')
    <!-- Cabeçalho -->
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-3">
        <div>
            <h4><strong>Editar</strong> <br /><small>{{ $tomador->nome_fantasia }}</small></h4>
        </div>
        <!-- botao -->
        <div class="ms-md-auto py-2 py-md-0">
            <div class="btn-group" role="group" aria-label="Basic example">
                <!-- botao voltar -->
                <a href="{{ route('empresas.tomador.index') }}" class="btn btn-primary btn-sm" title="Voltar">
                    <i class="fa-solid fa-arrow-left btn-icon-append"></i>
                </a>
            </div>
        </div>
        <!-- botao -->
    </div>
    <!-- Cabeçalho -->
    <form action="{{ route('empresas.tomador.update', $tomador->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-md-6">
                <label for="responsavel" class="form-label">Responsável</label>
                <input type="text" name="responsavel" id="responsavel" class="form-control"
                    value="{{ $tomador->responsavel }}">
            </div>
            <div class="col-md-6">
                <label for="cpf_responsavel" class="form-label">CPF Responsável</label>
                <input type="text" name="cpf_responsavel" id="cpf_responsavel" class="form-control cpf-mask"
                    value="{{ $tomador->cpf_responsavel }}">
            </div>
            <div class="col-md-6">
                <label for="nome_fantasia" class="form-label">Nome Fantasia</label>
                <input type="text" name="nome_fantasia" id="nome_fantasia" class="form-control"
                    value="{{ $tomador->nome_fantasia }}">
            </div>
            <div class="col-md-6">
                <label for="razao_social" class="form-label">Razão Social</label>
                <input type="text" name="razao_social" id="razao_social" class="form-control"
                    value="{{ $tomador->razao_social }}">
            </div>
            <div class="col-md-6">
                <label for="razao_social2" class="form-label">Razão Social 2</label>
                <input type="text" name="razao_social2" id="razao_social2" class="form-control"
                    value="{{ $tomador->razao_social2 }}">
            </div>
            <div class="col-md-6">
                <label for="razao_social3" class="form-label">Razão Social 3</label>
                <input type="text" name="razao_social3" id="razao_social3" class="form-control"
                    value="{{ $tomador->razao_social3 }}">
            </div>
            <div class="col-md-6">
                <label for="cnpj" class="form-label">CNPJ</label>
                <input type="text" name="cnpj" id="cnpj" class="form-control cnpj-mask"
                    value="{{ $tomador->cnpj }}">
            </div>
            <div class="col-md-6">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" name="telefone" id="telefone" class="form-control phone-mask"
                    value="{{ $tomador->telefone }}">
            </div>
            <div class="col-md-4">
                <label for="cep" class="form-label">CEP</label>
                <input type="text" name="cep" id="cep" class="form-control cep-mask"
                    value="{{ $tomador->cep }}">
            </div>
            <div class="col-md-4">
                <label for="estado" class="form-label">Estado</label>
                <input type="text" name="estado" id="estado" class="form-control" value="{{ $tomador->estado }}"
                   >
            </div>
            <div class="col-md-4">
                <label for="cidade" class="form-label">Cidade</label>
                <input type="text" name="cidade" id="cidade" class="form-control" value="{{ $tomador->cidade }}"
                   >
            </div>
            <div class="col-md-6">
                <label for="bairro" class="form-label">Bairro</label>
                <input type="text" name="bairro" id="bairro" class="form-control" value="{{ $tomador->bairro }}"
                   >
            </div>
            <div class="col-md-6">
                <label for="logradouro" class="form-label">Logradouro</label>
                <input type="text" name="logradouro" id="logradouro" class="form-control"
                    value="{{ $tomador->logradouro }}">
            </div>
            <div class="col-md-4">
                <label for="numero" class="form-label">Número</label>
                <input type="text" name="numero" id="numero" class="form-control"
                    value="{{ $tomador->numero }}">
            </div>
            <div class="col-md-8">
                <label for="complemento" class="form-label">Complemento</label>
                <input type="text" name="complemento" id="complemento" class="form-control"
                    value="{{ $tomador->complemento }}">
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-4">Enviar Alterações</button>
    </form>
@endsection
