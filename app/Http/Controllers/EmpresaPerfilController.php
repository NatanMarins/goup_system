<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\Holding;
use App\Models\HoldingUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EmpresaPerfilController extends Controller
{
    public function showHolding(){

        // Recuperar do banco de dados as informações do usuário logado
        $holdingId = Auth::user()->holding_id;
        $holding = Holding::where('id', $holdingId)->get()->first();

        $colaboradores = Holding::with('usuarios')->findOrFail($holdingId);

        // Carrega a view
        return view('holdings.empresa_profile.show', ['holding' => $holding, 'colaboradores' => $colaboradores]);
    }


    public function editHolding(){

        // Recuperar do banco de dados as informações do usuário logado
        $holdingId = Auth::user()->holding_id;
        $holding = Holding::where('id', $holdingId)->get()->first();

        return view('holdings.empresa_profile.edit', ['holding' => $holding]);
    }


    public function updateHolding(Request $request, Holding $holding){

        // Recuperar do banco de dados as informações do usuário logado
        $holdingId = Auth::user()->holding_id;
        $holding = Holding::where('id', $holdingId)->get()->first();


        $request->validate([
            'nome' => 'required|string|max:255',
            'cnpj' => 'required',
            'telefone' => 'required',
            'email' => 'required|email|',
            'endereco' => 'required',
        ],[
            // Mensagens de erro
            'nome.required' => 'O campo Nome é obrigatório.',
            'cnpj.required' => 'O campo CNPJ é obrigatório.',
            'telefone.required' => 'O campo Telefone é obrigatório.',
            'email.required' => 'O campo E-mail é obrigatório.',
            'email.email' => 'Cnpj inválido.',
            'email.unique' => 'Esse E-mail já está sendo usado.',
            'endereco.required' => 'O campo Endereço é obrigatório.',
        ]);

        $holding->update([
            'nome' => $request->nome,
            'cnpj' => $request->cnpj,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'endereco' => $request->endereco,
        ]);

        return redirect()->route('holdings.empresa_profile.show', ['holding' => $holding])->with('success', 'Perfil editado com sucesso!');
    }

    public function colaboradoresHolding()
    {

        // Recuperar do banco de dados as informações do usuário logado
        $holdingId = Auth::user()->holding_id;
        $holding = Holding::where('id', $holdingId)->get()->first();

        $userId = Auth::user()->id;

        // Recupera os usuários da holding, ordenando o usuário logado como o primeiro
        $colaboradores = HoldingUser::where('holding_id', $holdingId)
            ->orderByRaw("id = $userId DESC")
            ->get();

        // Carrega a view
        return view('holdings.empresa_profile.colaboradores', ['holding' => $holding, 'colaboradores' => $colaboradores]);
    }

    

    // A partir desse ponto as funções estão relacionadas com empresas

    public function showEmpresa(){

        // Recuperar do banco de dados as informações do usuário logado
        $empresaId = Auth::user()->empresa_id;
        $empresa = Empresa::where('id', $empresaId)->get()->first();

        $colaboradores = Empresa::with('usuarios')->findOrFail($empresaId);

        // Carrega a view
        return view('empresas.empresa_profile.show', ['empresa' => $empresa, 'colaboradores' => $colaboradores]);
    }


    public function editEmpresa(){

        // Recuperar do banco de dados as informações do usuário logado
        $empresaId = Auth::user()->empresa_id;
        $empresa = Empresa::where('id', $empresaId)->get()->first();

        return view('empresas.empresa_profile.edit', ['empresa' => $empresa]);
    }


    public function updateEmpresa(Request $request, Empresa $empresa){

        // Recuperar do banco de dados as informações do usuário logado
        $empresaId = Auth::user()->empresa_id;
        $empresa = Empresa::where('id', $empresaId)->get()->first();

        $request->validate([
            'nome' => 'required|string|max:255',
            'cnpj' => 'required',
            'telefone' => 'required',
            'email' => 'required|email|',
            'endereco' => 'required',
        ],[
            // Mensagens de erro
            'nome.required' => 'O campo Nome é obrigatório.',
            'cnpj.required' => 'O campo CNPJ é obrigatório.',
            'telefone.required' => 'O campo Telefone é obrigatório.',
            'email.required' => 'O campo E-mail é obrigatório.',
            'email.email' => 'Cnpj inválido.',
            'email.unique' => 'Esse E-mail já está sendo usado.',
            'endereco.required' => 'O campo Endereço é obrigatório.',
        ]);

        $empresa->update([
            'nome' => $request->nome,
            'cnpj' => $request->cnpj,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'endereco' => $request->endereco,
        ]);

        return redirect()->route('empresas.empresa_profile.show', ['empresa' => $empresa])->with('success', 'Perfil editado com sucesso!');
    }
}
