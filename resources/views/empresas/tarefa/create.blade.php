@extends('empresas.layout.admin')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-white">
            <h4 class="mb-0">Nova Tarefa</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('empresas.tarefa.store') }}" method="POST">
                @csrf
                <input type="hidden" name="data" value="{{ $data }}">
                
                <div class="mb-3">
                    <label class="form-label">Título</label>
                    <input type="text" class="form-control" name="titulo" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Descrição</label>
                    <textarea class="form-control" name="descricao" rows="3"></textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('empresas.tarefa.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

