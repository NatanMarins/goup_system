<?php

namespace App\Http\Controllers;

use App\Models\Assinatura;
use App\Models\cupom;
use App\Models\TomadoresPagamento;
use App\Models\TomadorServico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $totalAssinaturas = TomadoresPagamento::count();
        $pendentes = TomadorServico::where('situacao', 'pendente')->count();
        $adimplentes = TomadorServico::where('situacao', 's')->count();
        $inadimplentes = TomadorServico::where('situacao', 'inadimplente')->count();
        $abandonos = TomadorServico::where('situacao', 'abandono de carrinho')->count();

        // Calcular o percentual em relação ao total de assinaturas
        $percentual = $this->calcularPorcentagem($totalAssinaturas, $pendentes, $adimplentes, $inadimplentes, $abandonos);

        // Total Recebido: Considera apenas os tomadores adimplentes
        $totalRecebido = TomadoresPagamento::whereHas('tomadorServico', function ($query) {
            $query->where('status', 'adimplente');
        })->sum('value');

        // Total a Receber: Considera os tomadores pendentes
        $totalAReceber = TomadoresPagamento::whereHas('tomadorServico', function ($query) {
            $query->where('status', 'pendente');
        })->sum('value');

        $cupons = Cupom::count();
        $valoresAssinaturas = Assinatura::select('valor_mensal', 'valor_anual')->get();

        return view('empresas.admin.dashboard', compact(
            'totalAssinaturas',
            'pendentes',
            'adimplentes',
            'inadimplentes',
            'abandonos',
            'percentual',
            'totalRecebido',
            'totalAReceber',
            'cupons',
            'valoresAssinaturas'
        ));
    }

    private function calcularPorcentagem($totalAssinaturas, $pendentes, $adimplentes, $inadimplentes, $abandonos)
    {
        $percentual = [
            'pendentes' => ($pendentes / $totalAssinaturas) * 100,
            'adimplentes' => ($adimplentes / $totalAssinaturas) * 100,
            'inadimplentes' => ($inadimplentes / $totalAssinaturas) * 100,
            'abandonos' => ($abandonos / $totalAssinaturas) * 100,
        ];

        return $percentual;
    }

    // Logout area admin

    public function adminLogout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('empresas.dashboard.dashboard'); // 🔹 Redireciona para a rota desejada
    }
}
