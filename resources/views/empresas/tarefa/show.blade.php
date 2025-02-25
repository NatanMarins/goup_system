@extends('empresas.layout.admin')

@section('content')

    <div class="container">
        <h2 class="text-center">Tarefas do Dia: {{ \Carbon\Carbon::parse($data)->format('d/m/Y') }}</h2>

        <!-- Exibe as tarefas do dia -->
        @if ($tarefas->isEmpty())
            <p>Nenhuma tarefa cadastrada para este dia.</p>
        @else
            <ul>
                @foreach ($tarefas as $tarefa)
                    <li>{{ $tarefa->titulo }}: {{ $tarefa->descricao }}</li>
                @endforeach
            </ul>
        @endif
@endsection
