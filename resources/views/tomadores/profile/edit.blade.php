@extends('tomadores.layout.admin')

@section('content')
    <div class="container">
        <h2>Editar Dados do Tomador</h2>

        <x-alert />

        <form action="{{ route('tomadores.profile.update', $tomador->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <label>Nome Fantasia</label>
                    <input type="text" class="form-control" name="nome_fantasia" value="{{ $tomador->nome_fantasia }}">
                </div>

                <div class="col-md-6">
                    <label>Razão Social</label>
                    <input type="text" class="form-control" name="razao_social" value="{{ $tomador->razao_social }}">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label>CNPJ</label>
                    <input type="text" class="form-control" name="cnpj" value="{{ $tomador->cnpj }}">
                </div>

                <div class="col-md-6">
                    <label>Inscrição Estadual</label>
                    <input type="text" class="form-control" name="inscricao_estadual"
                        value="{{ $tomador->inscricao_estadual }}">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label>Inscrição Municipal</label>
                    <input type="text" class="form-control" name="inscricao_municipal"
                        value="{{ $tomador->inscricao_municipal }}">
                </div>
            </div>

            <div class="row mt-3">

                <div class="col-md-6">
                    <label>Capital Social</label>
                    <input type="text" class="form-control" name="capital_social" value="{{ $tomador->capital_social }}">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label>CNAE</label>
                    <input type="text" class="form-control" name="cnae" value="{{ $tomador->cnae }}">
                </div>

                <div class="col-md-6">
                    <label>Data Abertura</label>
                    <input type="date" class="form-control" name="data_abertura" value="{{ $tomador->data_abertura }}">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label>Código Tributação</label>
                    <input type="text" class="form-control" name="codigo_tributacao"
                        value="{{ $tomador->codigo_tributacao }}">
                </div>

                <div class="col-md-6">
                    <label>Email</label>
                    <input type="text" class="form-control" name="email" value="{{ $tomador->email }}">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label>Telefone</label>
                    <input type="text" class="form-control" name="telefone" value="{{ $tomador->telefone }}">
                </div>

                <div class="col-md-6">
                    <label>CEP</label>
                    <input type="text" class="form-control" name="cep" value="{{ $tomador->cep }}">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label>Estado</label>
                    <input type="text" class="form-control" name="estado" value="{{ $tomador->estado }}">
                </div>

                <div class="col-md-6">
                    <label>Cidade</label>
                    <input type="text" class="form-control" name="cidade" value="{{ $tomador->cidade }}">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label>Bairro</label>
                    <input type="text" class="form-control" name="bairro" value="{{ $tomador->bairro }}">
                </div>

                <div class="col-md-6">
                    <label>Logradouro</label>
                    <input type="text" class="form-control" name="logradouro" value="{{ $tomador->logradouro }}">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label>Número</label>
                    <input type="text" class="form-control" name="numero" value="{{ $tomador->numero }}">
                </div>

                <div class="col-md-6">
                    <label>Complemento</label>
                    <input type="text" class="form-control" name="complemento" value="{{ $tomador->complemento }}">
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                <button type="button" class="btn btn-secondary" onclick="history.back()">Cancelar</button>
            </div>
        </form>
    </div>
@endsection
