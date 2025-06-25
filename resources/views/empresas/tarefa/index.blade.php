@extends('empresas.layout.admin')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Calendário de Tarefas</h4>
                <div>
                    <select id="monthSelector" class="form-select" onchange="changeMonth(this.value)">
                        @foreach(range(1, 12) as $month)
                            @php
                                $date = Carbon\Carbon::create(null, $month, 1);
                                $selected = $month == $mesSelecionado->month ? 'selected' : '';
                            @endphp
                            <option value="{{ $date->format('Y-m') }}" {{ $selected }}>
                                {{ $date->translatedFormat('F Y') }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Dom</th><th>Seg</th><th>Ter</th><th>Qua</th><th>Qui</th><th>Sex</th><th>Sáb</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $diasNoMes = $mesSelecionado->daysInMonth;
                            $primeiroDia = $mesSelecionado->copy()->startOfMonth()->dayOfWeek;
                            $diaAtual = 1;
                        @endphp

                        @for($i = 0; $i < 6; $i++)
                            <tr>
                                @for($j = 0; $j < 7; $j++)
                                    @php
                                        $mostrarDia = ($i * 7 + $j >= $primeiroDia && $diaAtual <= $diasNoMes);
                                        if($mostrarDia) {
                                            $dataAtual = $mesSelecionado->copy()->day($diaAtual)->format('Y-m-d');
                                            $tarefas = $tarefasPorData[$dataAtual] ?? [];
                                        }
                                    @endphp
                                    
                                    <td class="position-relative" style="height: 100px; min-width: 120px;">
                                        @if($mostrarDia)
                                            <div class="position-absolute top-0 end-0 p-1">{{ $diaAtual }}</div>
                                            <div class="mt-4">
                                                @if(!empty($tarefas))
                                                    @foreach($tarefas as $tarefa)
                                                        <a href="{{ route('empresas.tarefa.edit', $tarefa['id']) }}" 
                                                           class="badge bg-primary mb-1 d-block text-truncate text-decoration-none">
                                                            {{ $tarefa['titulo'] }}
                                                        </a>
                                                    @endforeach
                                                @endif
                                                <a href="{{ route('empresas.tarefa.create', $dataAtual) }}" 
                                                   class="btn btn-sm btn-outline-success">
                                                    +
                                                </a>
                                            </div>
                                            @php $diaAtual++; @endphp
                                        @endif
                                    </td>
                                @endfor
                            </tr>
                            @if($diaAtual > $diasNoMes) @break @endif
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function changeMonth(value) {
        window.location.href = `{{ route('empresas.tarefa.index') }}?mes=${value}`;
    }
</script>
@endsection