<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\Holding;
use App\Models\HoldingUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function showHolding()
    {

        // Recuperar do banco de dados as informações do usuário logado
        $usuario = HoldingUser::where('id', Auth::id())->first();

        $holdingId = Auth::user()->holding_id;
        $holding = Holding::where('id', $holdingId)->get()->first();

        // Carrega a view
        return view('holdings.profile.show', compact('holding'), ['user' => $usuario]);
    }


    public function editHolding()
    {

        $user = HoldingUser::where('id', Auth::id())->first();

        // Carrega a view
        return view('holdings.profile.edit', ['user' => $user]);
    }


    public function updateHolding(Request $request, HoldingUser $usuario)
    {

        $usuario = HoldingUser::where('id', Auth::id())->first();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ], [
            // Mensagens de erro
            'nome.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo E-mail é obrigatório.',
            'email.email' => 'Insira um E-mail válido.',
        ]);

        // Atualiza os dados do usuário
        $usuario->name = $validatedData['name'];
        $usuario->email = $validatedData['email'];

        $usuario->save();

        return redirect()->route('holdings.profile.show')->with('success', 'Perfil editado com sucesso!');
    }


    public function editFotoHolding()
    {

        // Recuperar do banco de dados as informações do usuário logado
        $usuario = HoldingUser::where('id', Auth::id())->first();

        // Carrega a view
        return view('holdings.profile.edit-foto', ['user' => $usuario]);
    }


    public function updateFotoHolding(Request $request)
    {

        $usuario = Auth::user();

        // Validar o upload
        $request->validate([
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($request->hasFile('foto_perfil')) {
            // Deletar a foto de perfil anterior, se existir
            if ($usuario->foto_perfil) {
                Storage::disk('public')->delete($usuario->foto_perfil);
            }

            // Armazenar a nova foto de perfil
            $file = $request->file('foto_perfil');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads', $fileName, 'public');

            // Atualizar o caminho da foto de perfil no banco de dados
            $usuario->foto_perfil = $path;
            $usuario->save();
        }

        return redirect()->route('holdings.profile.show')->with('success', 'Foto de perfil atualizada com sucesso!');
    }


    public function editPasswordHolding()
    {
        $usuario = HoldingUser::where('id', Auth::id())->first();

        // Carrega a view
        return view('holdings.profile.edit-password', ['user' => $usuario]);
    }

    public function updatePasswordHolding(Request $request)
    {
        $usuario = HoldingUser::where('id', Auth::id())->first();


        // Validar o upload
        $request->validate([
            'senha_atual' => 'required',
            'password' => 'required|min:6',
        ], [
            'senha_atual.required' => 'Você precisa informar sua senha atual.',
            'password.required' => 'Você precisa informar uma nova senha.',
            'password.min' => 'A senha deve conter no mínimo :min caracteres.'
        ]);

        // Verifica se a senha atual está correta
        if (!Hash::check($request->senha_atual, Auth::user()->password)) {
            return back()->withErrors(['senha_atual' => 'A senha atual está incorreta.']);
        }

        // Editar as informações no banco de dados
        $usuario->update([
            'password' => $request->password,
        ]);

        return redirect()->route('holdings.profile.show')->with('success', 'Senha atualizada com sucesso!');
    }


    // A partir desse ponto as funções estão relacionadas com empresas


    public function showEmpresa()
    {

        // Recuperar do banco de dados as informações do usuário logado
        $usuario = User::where('id', Auth::id())->first();

        $empresaId = Auth::user()->empresa_id;
        $empresa = Empresa::where('id', $empresaId)->get()->first();

        // Carrega a view
        return view('empresas.profile.show', compact('empresa'), ['user' => $usuario]);
    }


    public function updateEmpresa(Request $request, User $usuario)
    {

        // Recuperar do banco de dados as informações do usuário logado
        $usuario = User::where('id', Auth::id())->first();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ], [
            // Mensagens de erro
            'nome.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo E-mail é obrigatório.',
            'email.email' => 'Insira um E-mail válido.',
        ]);

        // Atualiza os dados do usuário
        $usuario->name = $validatedData['name'];
        $usuario->email = $validatedData['email'];

        $usuario->save();

        return redirect()->route('empresas.profile.show')->with('success', 'Perfil editado com sucesso!');
    }

    public function updateFotoEmpresa(Request $request)
    {

        $usuario = Auth::user();

        // Validar o upload
        $request->validate([
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto_perfil')) {
            // Deletar a foto de perfil anterior, se existir
            if ($usuario->foto_perfil) {
                Storage::disk('public')->delete($usuario->foto_perfil);
            }

            // Armazenar a nova foto de perfil
            $file = $request->file('foto_perfil');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $path = $file->storeAs('foto_perfil', $fileName, 'public');

            // Atualizar o caminho da foto de perfil no banco de dados
            $usuario->foto_perfil = $path;
            $usuario->save();
        }

        return redirect()->back()->with('success', 'Foto de perfil atualizada com sucesso!');
    }

    public function updatePasswordEmpresa(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Você precisa informar sua senha atual.',
            'new_password.required' => 'Você precisa informar uma nova senha.',
            'new_password.min' => 'A senha deve conter no mínimo :min caracteres.',
            'new_password.confirmed' => 'As senhas não coincidem.',
        ]);
    
        $user = Auth::user();
    
        // Verifica se a senha atual está correta
        if (!Hash::check($validated['current_password'], $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'A senha atual está incorreta.']);
        }
    
        // Atualiza a senha
        $user->update([
            'password' => Hash::make($validated['new_password']),
        ]);
    
        return redirect()->back()->with('success', 'Senha alterada com sucesso!');
    }
}
