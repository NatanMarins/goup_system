<?php

namespace App\Http\Controllers;

use App\Models\GuiaImposto;
use App\Models\TomadorServico;
use Illuminate\Http\Request;

class GuiaImpostoController extends Controller
{
    public function index()
    {
        $guias = GuiaImposto::with('tomador')->get();
        return view('tomadores.impostos.index', compact('guias'));
    }

    public function create($tomadorservico)
    {
        $tomador = TomadorServico::findOrFail($tomadorservico);

        $guias = GuiaImposto::where('tomador_servico_id', $tomador->id)->get();

        return view('empresas.impostos.create', ['tomadorservico' => $tomador->id], compact('tomador', 'guias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'descricao' => 'required|string|max:255',
            'vencimento' => 'required|date',
            'path' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'tomador_id' => 'required|exists:tomadores_servicos,id',
        ]);

        $filePath = $request->file('path')->store('guias');

        GuiaImposto::create([
            'descricao' => $validated['descricao'],
            'vencimento' => $validated['vencimento'],
            'path' => $filePath,
            'tomador_id' => $validated['tomador_id'],
        ]);

        return redirect()->route('guias.index')->with('success', 'Guia de Imposto criada com sucesso.');
    }

    public function show(GuiaImposto $guia)
    {
        return response()->file(storage_path("app/{$guia->path}"));
    }
}
