@extends('empresas.layout.admin')

@section('content')
    <div class="container">
        <h1>Balancete - {{ $mes }}/{{ $ano }}</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Histórico</th>
                    <th>Descrição</th>
                    <th>Classificação</th>
                    <th>Descrição (Plano)</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lancamentosComPlano as $lancamento)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($lancamento['data_lancamento'])->format('d/m/Y') }}</td>
                        <td>{{ $lancamento['historico'] }}</td>
                        <td>{{ $lancamento['descricao_lancamento'] }}</td>
                        <td>{{ $lancamento['classificacao'] }}</td>
                        <td>{{ $lancamento['descricao_plano'] }}</td>
                        <td>{{ number_format($lancamento['valor'], 2, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Nenhum lançamento encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <h3>Resumo</h3>
        <p>Total de Entradas: R$ {{ number_format($totalEntradas, 2, ',', '.') }}</p>
        <p>Total de Saídas: R$ {{ number_format($totalSaidas, 2, ',', '.') }}</p>
        <p>Saldo: R$ {{ number_format($saldo, 2, ',', '.') }}</p>

        <a href="{{ route('empresas.contabilidade.balancete', $tomadorservico) }}" class="btn btn-secondary">Voltar</a>
        <a href="{{ route('empresas.contabilidade.balancetePdf', [$tomadorservico, $mes, $ano]) }}"
            class="btn btn-primary">Baixar PDF</a>
    </div>
@endsection
