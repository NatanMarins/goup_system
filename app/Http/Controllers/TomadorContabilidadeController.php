<?php

namespace App\Http\Controllers;

use App\Models\LancamentoExtrato;
use App\Models\PlanoDeContas;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use DateTime;
use Illuminate\Http\Request;

class TomadorContabilidadeController extends Controller
{
    public function uploadCsv()
    {
        return view('tomadores.contabilidade.uploadCsv');
    }

    public function processarCsv(Request $request)
    {
        // Validação do arquivo CSV
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        // Obter o arquivo e abrir
        $file = $request->file('csv_file');
        $handle = fopen($file->getPathname(), "r");

        // Tentar encontrar o cabeçalho (opcional)
        $headerFound = false;
        $firstDataRow = null;

        while (($data = fgetcsv($handle, 1000, ";")) !== false) {
            $firstColumn = trim($data[0] ?? '');
            if ($firstColumn === 'Data Lançamento') {
                $headerFound = true;
                break; // Cabeçalho encontrado, próxima linha será de dados
            } elseif (count($data) >= 4 && preg_match('/^\d{2}\/\d{2}\/\d{4}$/', trim($data[0]))) {
                // Se não for cabeçalho, mas a primeira coluna for uma data (ex.: 01/03/2025), assume como linha de dados
                $firstDataRow = $data;
                break;
            }
        }

        // Definir índices fixos para as colunas (ordem: data, histórico, descrição, valor)
        $indexDataLancamento = 0;
        $indexHistorico = 1;
        $indexDescricao = 2;
        $indexValor = 3;

        // Processar os dados
        $rowsProcessed = 0;
        if ($firstDataRow) {
            // Processar a primeira linha de dados (caso não tenha cabeçalho)
            $rowsProcessed += $this->processRow($firstDataRow, $indexDataLancamento, $indexHistorico, $indexDescricao, $indexValor);
        }

        // Continuar processando as demais linhas
        while (($data = fgetcsv($handle, 1000, ";")) !== false) {
            $rowsProcessed += $this->processRow($data, $indexDataLancamento, $indexHistorico, $indexDescricao, $indexValor);
        }

        fclose($handle);

        if ($rowsProcessed === 0) {
            return redirect()->back()->with('error', 'Nenhuma linha válida encontrada no CSV!');
        }

        return redirect()->back()->with('success', "Importação concluída com sucesso! $rowsProcessed linhas processadas.");
    }

    /**
     * Processa uma linha do CSV e insere no banco de dados
     */
    private function processRow($data, $indexDataLancamento, $indexHistorico, $indexDescricao, $indexValor)
    {
        // Verificar se a linha tem pelo menos 4 colunas e a data não está vazia
        if (count($data) < 4 || empty(trim($data[$indexDataLancamento]))) {
            return 0;
        }

        // Converter a data do formato DD/MM/YYYY para YYYY-MM-DD
        $dataLancamentoRaw = trim($data[$indexDataLancamento] ?? '');
        if ($dataLancamentoRaw) {
            $date = DateTime::createFromFormat('d/m/Y', $dataLancamentoRaw);
            $dataLancamento = $date ? $date->format('Y-m-d') : null;
        } else {
            $dataLancamento = null;
        }

        // Tratar o valor (ex.: "5.000,00" -> 5000.00 ou "-150,50" -> -150.50)
        $valorRaw = trim($data[$indexValor] ?? '0');
        $valor = (float) str_replace(',', '.', str_replace('.', '', $valorRaw));

        // Criar o registro no banco
        LancamentoExtrato::create([
            'data_lancamento' => $dataLancamento,
            'historico' => trim($data[$indexHistorico] ?? ''),
            'descricao' => trim($data[$indexDescricao] ?? ''),
            'valor' => $valor,
            'tomador_id' => auth()->user()->tomador_id ?? 1,
        ]);

        return 1; // Retorna 1 para indicar que uma linha foi processada
    }

    public function balancete($tomadorservico)
    {

        return view('empresas.contabilidade.balancete', compact('tomadorservico'));
    }

    public function gerarBalancete(Request $request, $tomadorservico)
    {
        $request->validate([
            'mes' => 'required|integer|between:1,12',
            'ano' => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        $mes = str_pad($request->mes, 2, '0', STR_PAD_LEFT); // Ex.: "03" para março
        $ano = $request->ano;

        // Filtrar lançamentos do mês e ano selecionados
        $lancamentos = LancamentoExtrato::whereYear('data_lancamento', $ano)
            ->whereMonth('data_lancamento', $mes)
            ->where('tomador_id', $tomadorservico)
            ->get();

        // Estrutura para armazenar os lançamentos com informações do plano de contas
        $lancamentosComPlano = [];

        // Percorrer os lançamentos e relacionar com plano_de_contas
        foreach ($lancamentos as $lancamento) {

            // Buscar correspondência em plano_de_contas
            $plano = $this->encontrarPlanoDeContas($lancamento->historico);

            $lancamentosComPlano[] = [
                'data_lancamento' => $lancamento->data_lancamento,
                'historico' => $lancamento->historico,
                'descricao' => $lancamento->descricao,
                'valor' => $lancamento->valor,
                'classificacao' => $plano['classificacao'],
                'descricao_plano' => $plano['descricao'],
            ];
        }

        // Calcular totais
        $totalEntradas = array_sum(array_column(array_filter($lancamentosComPlano, fn($item) => $item['valor'] > 0), 'valor'));
        $totalSaidas = array_sum(array_column(array_filter($lancamentosComPlano, fn($item) => $item['valor'] < 0), 'valor'));
        $saldo = $totalEntradas + $totalSaidas;

        // Armazenar os dados na sessão para reutilização no PDF
        session([
            'balancete_data' => [
                'lancamentosComPlano' => $lancamentosComPlano,
                'totalEntradas' => $totalEntradas,
                'totalSaidas' => $totalSaidas,
                'saldo' => $saldo,
                'mes' => $mes,
                'ano' => $ano,
                'tomadorservico' => $tomadorservico,
            ]
        ]);

        return view('empresas.contabilidade.balanceteResultado', compact('lancamentosComPlano', 'totalEntradas', 'totalSaidas', 'saldo', 'mes', 'ano', 'tomadorservico'));
    }

    /**
     * Regra de negócio para encontrar o plano de contas correspondente
     */
    private function encontrarPlanoDeContas($historico)
    {
        // Busca exata
        $plano = PlanoDeContas::where('descricao', $historico)->first();

        if ($plano) {
            return [
                'classificacao' => $plano->classificacao,
                'descricao' => $plano->descricao,
            ];
        }

        // Busca parcial (historico contido na descricao)
        $plano = PlanoDeContas::where('descricao', 'LIKE', "%{$historico}%")->first();

        if ($plano) {
            return [
                'classificacao' => $plano->classificacao,
                'descricao' => $plano->descricao,
            ];
        }

        // Valor padrão se não encontrar correspondência
        return [
            'classificacao' => 'Não classificado',
            'descricao' => 'Não classificado',
        ];
    }

    public function downloadPdf($tomadorservico, $mes, $ano)
    {
        // Verificar se os dados estão na sessão e correspondem aos parâmetros
        $balanceteData = session('balancete_data');

        if (!$balanceteData || 
            $balanceteData['tomadorservico'] != $tomadorservico || 
            $balanceteData['mes'] != str_pad($mes, 2, '0', STR_PAD_LEFT) || 
            $balanceteData['ano'] != $ano) {
            // Se os dados não estão na sessão ou não correspondem, redirecionar ou gerar novamente (fallback)
            return redirect()->route('empresas.contabilidade.balancete', $tomadorservico)
                ->with('error', 'Dados do balancete não encontrados. Gere o balancete novamente.');
        }

        // Pegar os dados da sessão
        $lancamentosComPlano = $balanceteData['lancamentosComPlano'];
        $totalEntradas = $balanceteData['totalEntradas'];
        $totalSaidas = $balanceteData['totalSaidas'];
        $saldo = $balanceteData['saldo'];
        $mes = $balanceteData['mes'];
        $ano = $balanceteData['ano'];
        $tomadorservico = $balanceteData['tomadorservico'];

        // Gerar o PDF
        $pdf = FacadePdf::loadView('empresas.contabilidade.balancetePdf', compact('lancamentosComPlano', 'totalEntradas', 'totalSaidas', 'saldo', 'mes', 'ano', 'tomadorservico'));

        // Fazer o download do PDF
        return $pdf->download("balancete_{$mes}_{$ano}.pdf");
    }
}
