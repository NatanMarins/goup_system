@extends('empresas.layout.admin')

@section('content')


    <div class="container">
        <h2 class="text-center">Adicionar Tarefa Dia: {{ \Carbon\Carbon::parse($data)->format('d/m/Y') }}</h2>

        <!-- Formulário para adicionar tarefa -->
        <form action="{{ route('empresas.tarefa.store') }}" method="POST">
            @csrf
            <input type="hidden" name="data" value="{{ $data }}">

            <div class="mb-3">
                <label for="titulo" class="form-label">Título da Tarefa</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Adicionar Tarefa</button>
        </form>
    </div>

@endsection

