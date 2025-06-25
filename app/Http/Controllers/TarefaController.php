<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TarefaController extends Controller
{
    public function index(Request $request)
    {
        $mesSelecionado = Carbon::now();
        
        if ($request->has('mes')) {
            $mesSelecionado = Carbon::createFromFormat('Y-m', $request->mes);
        }

        $tarefas = Tarefa::whereMonth('data', $mesSelecionado->month)
            ->whereYear('data', $mesSelecionado->year)
            ->get();

        $tarefasPorData = [];
        foreach ($tarefas as $tarefa) {
            $data = Carbon::parse($tarefa->data)->format('Y-m-d');
            $tarefasPorData[$data][] = [
                'id' => $tarefa->id,
                'titulo' => $tarefa->titulo,
                'descricao' => $tarefa->descricao,
            ];
        }

        return view('empresas.tarefa.index', compact('mesSelecionado', 'tarefasPorData'));
    }

    public function create($data)
    {
        return view('empresas.tarefa.create', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|max:255',
            'descricao' => 'nullable',
            'data' => 'required|date',
        ]);

        Tarefa::create($validated);

        return redirect()->route('empresas.tarefa.index')
            ->with('success', 'Tarefa criada com sucesso!');
    }

    public function edit(Tarefa $tarefa)
    {
        return view('empresas.tarefa.edit', compact('tarefa'));
    }

    public function update(Request $request, Tarefa $tarefa)
    {
        $validated = $request->validate([
            'titulo' => 'required|max:255',
            'descricao' => 'nullable',
            'data' => 'required|date',
        ]);

        $tarefa->update($validated);

        return redirect()->route('empresas.tarefa.index')
            ->with('success', 'Tarefa atualizada com sucesso!');
    }

    public function destroy(Tarefa $tarefa)
    {
        $tarefa->delete();

        return redirect()->route('empresas.tarefa.index')
            ->with('success', 'Tarefa excluída com sucesso!');
    }

    public function indexTomador(Request $request)
    {
        $mesSelecionado = Carbon::now();
        
        if ($request->has('mes')) {
            $mesSelecionado = Carbon::createFromFormat('Y-m', $request->mes);
        }

        $tarefas = Tarefa::whereMonth('data', $mesSelecionado->month)
            ->whereYear('data', $mesSelecionado->year)
            ->get();

        $tarefasPorData = [];
        foreach ($tarefas as $tarefa) {
            $data = Carbon::parse($tarefa->data)->format('Y-m-d');
            $tarefasPorData[$data][] = [
                'id' => $tarefa->id,
                'titulo' => $tarefa->titulo,
                'descricao' => $tarefa->descricao,
            ];
        }

        return view('tomadores.tarefas.index', compact('mesSelecionado', 'tarefasPorData'));
    }
}
