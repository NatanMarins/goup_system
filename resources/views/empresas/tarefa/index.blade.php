@extends('empresas.layout.admin')

@section('content')
    @php
        setlocale(LC_TIME, 'pt_BR.utf8'); // Define o idioma para português
    @endphp

    <!-- Cabeçalho -->
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Calendário de Eventos -
                <strong>{{ ucfirst($mesSelecionado->translatedFormat('F Y')) }}</strong>
            </h3>
        </div>
    </div>
    <!-- Cabeçalho -->

    <!-- Conteúdo -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body">

                    <!-- Botões para selecionar o mês -->
                    <div class="mb-4 text-center">
                        @foreach (range(1, 12) as $mes)
                            @php
                                $dataMes = Carbon\Carbon::create(Carbon\Carbon::now()->year, $mes, 1);
                            @endphp
                            <a href="{{ route('empresas.tarefa.index', ['mes' => $dataMes->format('Y-m')]) }}"
                                class="btn btn-outline-primary btn-sm px-2 py-1 m-1 {{ $mesSelecionado->month == $mes ? 'active' : '' }}">
                                {{ ucfirst($dataMes->translatedFormat('M')) }}
                            </a>
                        @endforeach
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>Dom</th>
                                    <th>Seg</th>
                                    <th>Ter</th>
                                    <th>Qua</th>
                                    <th>Qui</th>
                                    <th>Sex</th>
                                    <th>Sáb</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $diasNoMes = $mesSelecionado->daysInMonth;
                                    $primeiroDiaDoMes = $mesSelecionado->copy()->startOfMonth();
                                    $diaDaSemanaPrimeiroDia = $primeiroDiaDoMes->dayOfWeek;
                                    $contador = 0;
                                @endphp

                                <tr>
                                    @for ($j = 0; $j < $diaDaSemanaPrimeiroDia; $j++)
                                        <td></td>
                                        @php $contador++; @endphp
                                    @endfor

                                    @for ($i = 1; $i <= $diasNoMes; $i++)
                                        @php
                                            $dataAtual = $mesSelecionado->copy()->day($i)->toDateString();
                                            $quantidadeTarefas = $tarefasPorData[$dataAtual] ?? 0;
                                        @endphp

                                        <td class="position-relative">
                                            <a href="{{ route('empresas.tarefa.create', $dataAtual) }}"
                                                class="btn btn-light">
                                                {{ $i }}
                                            </a>
                                            @if ($quantidadeTarefas > 0)
                                                <a href="{{ route('empresas.tarefa.show', $dataAtual) }}">
                                                    <span
                                                        class="badge bg-warning position-absolute top-0 end-0">{{ $quantidadeTarefas }}
                                                        Tarefa(s)</span>
                                                </a>
                                            @endif
                                        </td>

                                        @php $contador++; @endphp

                                        @if ($contador % 7 == 0)
                                </tr>
                                <tr>
                                    @endif
                                    @endfor

                                    @while ($contador % 7 != 0)
                                        <td></td>
                                        @php $contador++; @endphp
                                    @endwhile
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
