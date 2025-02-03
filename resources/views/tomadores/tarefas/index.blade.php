@extends('tomadores.layout.admin')

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

    <!-- Botões para selecionar o mês -->
    <div class="mb-4 text-center">
        @foreach (range(1, 12) as $mes)
            @php
                $dataMes = Carbon\Carbon::create(Carbon\Carbon::now()->year, $mes, 1);
            @endphp
            <a href="{{ route('tomadores.tarefas.index', ['mes' => $dataMes->format('Y-m')]) }}"
                class="btn btn-outline-primary btn-sm px-2 py-1 m-1 {{ $mesSelecionado->month == $mes ? 'active' : '' }}">
                {{ ucfirst($dataMes->translatedFormat('M')) }}
            </a>
        @endforeach
    </div>

    <!-- Conteúdo -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body">
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
                                            <button class="btn btn-light w-100" onclick="verTarefas('{{ $dataAtual }}')">
                                                {{ $i }}
                                            </button>
                                            @if ($quantidadeTarefas > 0)
                                                <span class="badge bg-warning position-absolute top-0 end-0">
                                                    {{ $quantidadeTarefas }} Tarefa(s)
                                                </span>
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

    <!-- Modal para Exibir as Tarefas -->
    <div class="modal fade" id="modalTarefas" tabindex="-1" aria-labelledby="modalTarefasLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTarefasLabel">Tarefas do Dia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <ul id="listaTarefas" class="list-group">
                        <li class="list-group-item text-center">Carregando...</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function verTarefas(data) {
            console.log("Buscando tarefas para a data:", data); // Debugging

            fetch(`{{ url('tomadores/tarefa/show') }}/${data}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao carregar as tarefas');
                    }
                    return response.json();
                })
                .then(data => {
                    let listaTarefas = document.getElementById('listaTarefas');
                    listaTarefas.innerHTML = '';

                    if (data.length === 0) {
                        listaTarefas.innerHTML =
                            '<li class="list-group-item text-center">Nenhuma tarefa para este dia.</li>';
                    } else {
                        data.forEach(tarefa => {
                            let item = document.createElement('li');
                            item.classList.add('list-group-item');
                            item.textContent = tarefa.descricao;
                            listaTarefas.appendChild(item);
                        });
                    }

                    let modalElement = document.getElementById('modalTarefas');
                    let modal = new bootstrap.Modal(modalElement);
                    modal.show();
                })
                .catch(error => {
                    console.error('Erro ao carregar as tarefas:', error);
                    alert("Erro ao carregar as tarefas. Tente novamente.");
                });
        }
    </script>

@endsection