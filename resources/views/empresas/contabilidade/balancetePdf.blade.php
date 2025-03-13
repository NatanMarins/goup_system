<!DOCTYPE html>
<html>
<head>
    <title>Balancete - {{ $mes }}/{{ $ano }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; }
        .resumo { margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Balancete - {{ $mes }}/{{ $ano }}</h1>

    <table>
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
                    <td>{{ $lancamento['descricao'] }}</td>
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

    <div class="resumo">
        <p><strong>Total de Entradas:</strong> R$ {{ number_format($totalEntradas, 2, ',', '.') }}</p>
        <p><strong>Total de Saídas:</strong> R$ {{ number_format($totalSaidas, 2, ',', '.') }}</p>
        <p><strong>Saldo:</strong> R$ {{ number_format($saldo, 2, ',', '.') }}</p>
    </div>
</body>
</html>