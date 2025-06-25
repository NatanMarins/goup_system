@extends('empresas.layout.admin')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Editar Tarefa</h4>
            <form action="{{ route('empresas.tarefa.destroy', $tarefa->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?')">
                    Excluir
                </button>
            </form>
        </div>
        <div class="card-body">
            <form action="{{ route('empresas.tarefa.update', $tarefa->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="data" value="{{ $tarefa->data }}">
                
                <div class="mb-3">
                    <label class="form-label">Título</label>
                    <input type="text" class="form-control" name="titulo" value="{{ $tarefa->titulo }}" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Descrição</label>
                    <textarea class="form-control" name="descricao" rows="3">{{ $tarefa->descricao }}</textarea>
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