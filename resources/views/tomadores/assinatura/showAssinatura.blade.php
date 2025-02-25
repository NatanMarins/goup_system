@extends('tomadores.layout.admin')

@section('content')

    <div class="container mt-5">
        <h2 class="text-center mb-4">Detalhes da Assinatura</h2>
        <div class="card shadow-lg p-4">
            <div class="card-body">
                <h4 class="card-title">Plano: <strong>{{ $assinatura->description }}</strong></h4>
                <p><strong>Valor:</strong> R$ {{ number_format($assinatura->value, 2, ',', '.') }}</p>
                <p><strong>Forma de Pagamento:</strong>
                    @if ($assinatura->billingType == 'CREDIT_CARD')
                        CARTÃO DE CRÉDITO
                    @else
                        {{ $assinatura->billingType }}
                    @endif
                </p>
                <p><strong>Ciclo de Pagamento:</strong>
                    @if ($assinatura->cycle == 'MONTHLY')
                        MENSAL

                    @elseif ($assinatura->cycle == 'YEARLY')
                        ANUAL
                    @endif
                </p>
                <p>
                    <strong>Status:</strong>
                    <span
                        class="badge bg-{{ $tomador->status == 'ativo' ? 'success' : ($tomador->status == 'pendente' ? 'warning' : 'danger') }}">
                        {{ ucfirst($tomador->status) }}
                    </span>
                </p>

                @if ($assinatura->ciclo == 'mensal')
                    <p><strong>Próximos Vencimentos:</strong></p>
                    <ul>
                        @foreach ($assinatura->vencimentos as $vencimento)
                            <li>{{ date('d/m/Y', strtotime($vencimento)) }}</li>
                        @endforeach
                    </ul>
                @endif

                <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#detalhesModal">Ver Mais
                    Detalhes</button>
            </div>
        </div>
    </div>

    <!-- Modal de Detalhes -->
    <div class="modal fade" id="detalhesModal" tabindex="-1" aria-labelledby="detalhesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detalhesModalLabel">Pagamentos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
