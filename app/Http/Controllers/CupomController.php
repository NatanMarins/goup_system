<?php

namespace App\Http\Controllers;

use App\Models\Cupom;
use Exception;
use Illuminate\Http\Request;

class CupomController extends Controller
{
    public function indexCupom()
    {
        $cupons = Cupom::all();

        return view('empresas.assinatura.cupom', compact('cupons'));
    }

    public function storeCupom(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:255',
            'percentual' => 'required|numeric',
        ], [
            'codigo.required' => 'O campo código é obrigatório.',
            'percentual.required' => 'O campo percentual é obrigatório.',
        ]);

        Cupom::create($request->all());

        return redirect()->back()->with('success', 'Cupom adicionado com sucesso!');
    }

    public function deleteCupom(Cupom $cupom){

        try{
            //Excluir registro
            $cupom->delete();

            //Redirecionar o usuário
            return redirect()->back()->with('success', 'Cupom excluido com sucesso!');
        } catch(Exception $e){
            return redirect()->back()->with('error', 'Cupom não excluído!');
        }

    }
}
