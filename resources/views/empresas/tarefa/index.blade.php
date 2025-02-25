@extends('empresas.layout.admin')

@section('content')
    @php
        setlocale(LC_TIME, 'pt_BR.utf8');
        $anoAtual = Carbon\Carbon::now()->year;
        $mesAtual = $mesSelecionado->month;
    @endphp

    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h4 class="fw-bold">Calendário de Eventos -
                <strong>{{ ucfirst($mesSelecionado->translatedFormat('F Y')) }}</strong>
            </h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body">
                    <!-- Botões de Paginação -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('empresas.tarefa.index', ['mes' => $mesSelecionado->copy()->subMonth()->format('Y-m')]) }}"
                        class="btn btn-secondary btn-sm px-3">
                            &laquo; Anterior
                        </a>
                    
                        <a href="{{ route('empresas.tarefa.index', ['mes' => $mesSelecionado->copy()->addMonth()->format('Y-m')]) }}"
                        class="btn btn-secondary btn-sm px-3">
                            Próximo &raquo;
                        </a>
                    </div>

                    <!-- Linha de meses -->
                    <div class="mb-2 text-center pt-3">
                        @foreach (range(1, 12) as $mes)
                            @php
                                $dataMes = Carbon\Carbon::create($anoAtual, $mes, 1);
                                $isActive = $mes == $mesAtual;
                            @endphp
                            <a href="{{ $isActive ? '#' : route('empresas.tarefa.index', ['mes' => $dataMes->format('Y-m')]) }}"
                               class="btn btn-sm px-3 py-1 m-1 text-white 
                                      {{ $isActive ? 'bg-dark' : 'bg-danger' }}" 
                               style="border-color: #cccccc; pointer-events: {{ $isActive ? 'none' : 'auto' }};">
                                {{ ucfirst($dataMes->translatedFormat('M')) }}
                            </a>
                        @endforeach
                    </div>

                    

                    <!-- Tabela de Calendário -->
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>Dom</th><th>Seg</th><th>Ter</th><th>Qua</th><th>Qui</th><th>Sex</th><th>Sáb</th>
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
                                            $tarefa = $tarefasPorData[$dataAtual] ?? null;
                                            $badgeColor = isset($tarefa['data_entrega']) && $tarefa['data_entrega'] < date('Y-m-d') ? 'danger' : 'success';
                                            $badgeText = isset($tarefa['titulo']) ? implode(' ', array_slice(explode(' ', $tarefa['titulo']), 0, 2)) : '';
                                            $progress = isset($tarefa['progresso']) ? $tarefa['progresso'] : 0;
                                        @endphp

                                        <td class="position-relative p-1" style="font-size: 0.8rem;">
                                            <a href="#" class="d-block w-100 h-100 p-2 text-decoration-none text-dark"
                                               data-bs-toggle="modal" data-bs-target="#taskModal"
                                               onclick="showTaskModal('{{ $dataAtual }}', '{{ $tarefa['titulo'] ?? 'Nova Tarefa' }}', '{{ $tarefa['descricao'] ?? '' }}', '{{ $tarefa['data_entrega'] ?? '' }}', '{{ $progress }}')">
                                                @if ($tarefa)
                                                    <span class="badge bg-{{ $badgeColor }} position-absolute top-0 start-0">{{ $badgeText }}</span>
                                                @endif
                                                <span class="position-absolute bottom-0 end-0 p-1">{{ $i }}</span>
                                                <div class="progress mt-2">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progress }}%">{{ $progress }}%</div>
                                                </div>
                                            </a>
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

    <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskTitle">Gerenciar Tarefa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label><strong>Título:</strong></label>
                    <input type="text" id="taskTitleInput" class="form-control" placeholder="Digite o título">
                    <label class="mt-2"><strong>Descrição:</strong></label>
                    <input type="text" id="taskDescription" class="form-control" placeholder="Digite a descrição">
                    <label class="mt-2"><strong>Data de Entrega:</strong></label>
                    <input type="date" id="taskDate" class="form-control">
                    <div id="taskAlert" class="alert alert-danger d-none mt-2">Tarefa Atrasada!</div>
                    <div class="progress mt-2">
                        <div id="taskProgress" class="progress-bar bg-success" role="progressbar" style="width: 0%">0%</div>
                    </div>
                    <button class="btn btn-success mt-3">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTaskModal(date, title, description, deadline, progress) {
            document.getElementById("taskTitle").innerText = title || "Nova Tarefa";
            document.getElementById("taskTitleInput").value = title;
            document.getElementById("taskDescription").value = description;
            document.getElementById("taskDate").value = deadline;
            let progressBar = document.getElementById("taskProgress");
            progressBar.style.width = progress + "%";
            progressBar.innerText = progress + "%";
            document.getElementById("taskAlert").classList.toggle("d-none", !deadline || new Date(deadline) >= new Date());
        }
    </script>
@endsection