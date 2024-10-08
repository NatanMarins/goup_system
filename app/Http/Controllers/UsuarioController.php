<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsuarioRequest;
use App\Models\Empresa;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    public function index(){

        $usuarios = User::all();

        return view('usuario.index', compact('usuarios'));
    }


    public function show(User $usuario){

        $empresaId = Auth::user()->empresa_id;
        $empresa = Empresa::where('id', $empresaId)->get()->first();

        return view('usuario.show', compact('empresa'), ['user' => $usuario]);
    }


    public function create(){

        //$roles = Role::pluck('name')->all();

        //return view('usuario.create', ['roles' => $roles]);
        return view('usuario.create');
    }


    public function store(Request $request){

        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'empresa_id' => 'required',
        ]);

        $usuario = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'empresa_id' => $request['empresa_id'],
        ]);

        return redirect()->route('usuario.index')->with('success', 'Cadastrado com sucesso!');
    }


    public function edit(User $usuario){

        //$roles = Role::pluck('name')->all();

        //$usuarioRoles = $usuario->roles->pluck('name')->first();

        //return view('usuario.edit', ['usuario' => $usuario, 'roles' => $roles, 'usuarioRoles' => $usuarioRoles]);
        return view('usuario.edit', ['usuario' => $usuario]);

    }


    public function update(Request $request, User $usuario){

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        // Atualiza os dados do usuário
        $usuario->name = $validatedData['name'];
        $usuario->email = $validatedData['email'];

        return redirect()->route('usuario.show', ['usuario' => $request->usuario])->with('success', 'Usuário editado!');
    }


    public function editPassword(){

        // Recuperar do banco de dados as informações do usuário logado
        $usuario = User::where('id', Auth::id())->first();

        // Carrega a view
        return view('profile.edit-password', ['user' => $usuario]);
    }


    public function updatePassword(Request $request)
    {
        // Recuperar do banco de dados as informações do usuário logado
        $usuario = User::where('id', Auth::id())->first();

        // Validar o upload
        $request->validate([
            'password' => 'required|min:6',
        ],[
            'password.required' => 'Campo senha é obrigatório!',
            'password.min' => 'A senha deve conter no mínimo :min caracteres.'
        ]);

        // Editar as informações no banco de dados
        $usuario->update([
            'password' => $request->password,
        ]);

        return redirect()->route('usuario.show', ['usuario' => $request->usuario])->with('success', 'Senha atualizada com sucesso!');
    }


    public function destroy(User $usuario){

        try{
            //Excluir registro
            $usuario->delete();

            // Remove todos os papéis atribuídos ao usuário
            $usuario->syncRoles([]);

            //Redirecionar o usuário
            return redirect()->route('usuario.index')->with('success', 'Usuário excluido com sucesso!');
        } catch(Exception $e){
            return redirect()->route('usuario.index')->with('error', 'Usuário não excluído!');
        }

    }
}

