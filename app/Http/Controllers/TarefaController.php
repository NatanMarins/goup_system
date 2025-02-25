<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TarefaController extends Controller
{
    public function index(Request $request)
    {
        $mesSelecionado = $request->input('mes') ? Carbon::createFromFormat('Y-m', $request->input('mes')) : Carbon::now();
        $mesAnterior = $mesSelecionado->copy()->subMonth();
        $mesProximo = $mesSelecionado->copy()->addMonth();

        // Obter todas as tarefas agrupadas por data, junto com a contagem de tarefas para cada dia no mês selecionado
        $tarefasPorData = Tarefa::whereYear('data', $mesSelecionado->year)
            ->whereMonth('data', $mesSelecionado->month)
            ->select('data', DB::raw('count(*) as total'))
            ->groupBy('data')
            ->get()
            ->pluck('total', 'data')
            ->toArray();

        // Renderizar a view completa (incluindo layout) com o calendário do mês selecionado
        return view('empresas.tarefa.index', compact('mesSelecionado', 'mesAnterior', 'mesProximo', 'tarefasPorData'));
    }

    public function create($data)
    {
        // Buscar todas as tarefas para um dia específico
        $tarefas = Tarefa::where('data', $data)->get();

        return view('empresas.tarefa.create', compact('tarefas', 'data'));
    }

    public function store(Request $request)
    {
        // Valida os dados
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'data' => 'required|date',
        ]);

        // Cria a tarefa
        Tarefa::create($request->all());

        return redirect()->route('empresas.tarefa.index')->with('success', 'Tarefa adicionada com sucesso!');
    }

    public function showTarefas($data)
    {
        // Buscar todas as tarefas para um dia específico
        $tarefas = Tarefa::where('data', $data)->get();

        return view('empresas.tarefa.show', compact('tarefas', 'data'));
    }

    // Agenda Tomador

    public function indexTomador(Request $request)
    {
        $mesSelecionado = $request->input('mes') ? Carbon::createFromFormat('Y-m', $request->input('mes')) : Carbon::now();
        $mesAnterior = $mesSelecionado->copy()->subMonth();
        $mesProximo = $mesSelecionado->copy()->addMonth();

        // Obter todas as tarefas agrupadas por data, junto com a contagem de tarefas para cada dia no mês selecionado
        $tarefasPorData = Tarefa::whereYear('data', $mesSelecionado->year)
            ->whereMonth('data', $mesSelecionado->month)
            ->select('data', DB::raw('count(*) as total'))
            ->groupBy('data')
            ->get()
            ->pluck('total', 'data')
            ->toArray();

        // Renderizar a view completa (incluindo layout) com o calendário do mês selecionado
        return view('tomadores.tarefas.index', compact('mesSelecionado', 'mesAnterior', 'mesProximo', 'tarefasPorData'));
    }

    public function showTomador($data)
    {
        $tarefas = Tarefa::whereDate('data', $data)->get(['descricao']);
        return response()->json($tarefas);
    }
}
