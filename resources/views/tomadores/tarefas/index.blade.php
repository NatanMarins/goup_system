@extends('tomadores.layout.admin')

@section('content')
<style>
    .tooltip-inner {
        max-width: 300px;
        padding: 10px 15px;
        background-color: #fff;
        color: #333;
        border: 1px solid #ddd;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        border-radius: 6px;
        font-size: 14px;
        text-align: left;
    }

    .tooltip.bs-tooltip-top .tooltip-arrow::before {
        border-top-color: #ddd;
    }

    .tarefa-badge {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .tarefa-badge:hover {
        transform: translateY(-2px);
    }

    .tarefa-titulo {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
        color: #333;
    }

    .tarefa-descricao {
        font-weight: normal;
        font-size: 13px;
        color: #666;
    }
</style>

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
                                                        <div class="badge bg-primary mb-1 d-block text-truncate tarefa-badge" 
                                                             data-bs-toggle="tooltip" 
                                                             data-bs-placement="top" 
                                                             data-bs-html="true"
                                                             title="<span class='tarefa-titulo'>{{ $tarefa['titulo'] }}</span><span class='tarefa-descricao'>{{ $tarefa['descricao'] }}</span>">
                                                            {{ $tarefa['titulo'] }}
                                                        </div>
                                                    @endforeach
                                                @endif
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                html: true,
                container: 'body',
                trigger: 'hover',
                template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
            });
        });
    });

    function changeMonth(value) {
        window.location.href = `{{ route('tomadores.tarefas.index') }}?mes=${value}`;
    }
</script>
@endpush
@endsection