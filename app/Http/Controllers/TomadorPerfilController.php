<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TomadorPerfilController extends Controller
{
    public function showTomador()
    {
        $tomador = auth()->user();

        return view('tomadores.profile.show', compact('tomador'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'senhaAtual' => 'required',
            'novaSenha' => 'required|min:6',
            'confirmarSenha' => 'required',
        ]);

        $tomador = auth()->user();

        // Verifica se a senha atual está correta
        if (!Hash::check($request->senhaAtual, $tomador->password)) {
            return redirect()->back()->with('error', 'Senha atual incorreta!');
        }

        // Verifica se a nova senha é igual a senha de confirmação
        if ($request->novaSenha != $request->confirmarSenha) {
            return redirect()->back()->with('error', 'As senhas não coincidem!');
        }

        // Atualiza a senha do tomador
        $tomador->password = Hash::make($request->novaSenha);
        $tomador->save();


        return redirect()->back()->with('success', 'Senha alterada com sucesso!');
    }

    public function addDocumentos()
    {
        return view('tomadores.profile.addDocumentos');
    }
}
