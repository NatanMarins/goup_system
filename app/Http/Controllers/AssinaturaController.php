<?php

namespace App\Http\Controllers;

use App\Models\Assinatura;
use App\Models\TomadoresPagamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssinaturaController extends Controller
{
    public function config()
    {
        // Busca todos os planos na tabela `assinaturas`
        $planos = Assinatura::all();

        return view('empresas.assinatura.configuracao', compact('planos'));
    }

    public function update(Request $request)
    {
        // Valida os campos recebidos
        $request->validate([
            'planos.*.valor_mensal' => 'required|numeric|min:0',
            'planos.*.valor_anual' => 'required|numeric|min:0',
        ]);

        foreach ($request->planos as $id => $dados) {
            // Atualiza os valores dos planos no banco
            $plano = Assinatura::findOrFail($id);
            $plano->update([
                'valor_mensal' => $dados['valor_mensal'],
                'valor_anual' => $dados['valor_anual'],
            ]);
        }

        return redirect()->back()->with('success', 'Planos atualizados com sucesso!');
    }

    public function showAssinatura()
    {
        $tomador = Auth::user();

        $assinatura = TomadoresPagamento::where('tomador_servico_id', $tomador->id)->get()->first();

        return view('tomadores.assinatura.showAssinatura', compact('assinatura', 'tomador'));
    }
}
