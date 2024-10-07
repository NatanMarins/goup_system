<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Holding;
use Illuminate\Http\Request;

class HoldingController extends Controller
{
    public function index()
    {

        $holdings = Holding::all();

        return view('holding.index', compact('holdings'));
    }

    public function show($holding)
    {

        $empresas = Holding::with('empresas')->findOrFail($holding);

        $holding = Holding::findOrFail($holding);

        return view('holding.show', compact('holding', 'empresas'));
    }

    public function create()
    {

        $holdings = Holding::all();

        return view('holding.create');
    }

    public function store(Request $request)
    {

        dd($request);

        return;
    }

    public function edit($holding)
    {

        $holding = Holding::findOrFail($holding);

        return view('holding.edit', compact('holding'));
    }

    public function update(Request $request)
    {

        dd($request);

        return;
    }
}