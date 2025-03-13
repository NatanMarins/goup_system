<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {

        return view('login.index');
    }

    public function loginProcess(LoginRequest $request)
    {

        // Validar o formulário
        $request->validated();

        // Primeira tentativa: tentar autenticar o usuário da tabela 'users'
        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            // Se o login for bem-sucedido, redireciona para o dashboard do usuário
            return redirect()->route('empresas.dashboard.dashboard');
        }

        // Segunda tentativa: tentar autenticar o usuário da tabela 'holding_users'
        if (Auth::guard('holding')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            // Se o login for bem-sucedido, redireciona para o dashboard da holding
            return redirect()->route('holdings.dashboard.dashboard');
        }

        // Terceira tentativa: tentar autenticar o usuário da tabela 'tomadores_servicos'
        if (Auth::guard('tomador')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            // Se o login for bem-sucedido, redireciona para o dashboard da holding
            return redirect()->route('tomadores.dashboard.dashboard');
        }

        // Se ambas as tentativas falharem, redireciona de volta com erro
        return redirect()->back()->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => 'As credenciais fornecidas não correspondem aos nossos registros.']);
    }

    public function destroy(Request $request)
    {

        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        } elseif (Auth::guard('holding')->check()) {
            Auth::guard('holding')->logout();
        } elseif (Auth::guard('tomador')->check()) {
            Auth::guard('tomador')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(url('/') . '/')->with('success', 'Deslogado com sucesso!');
    }


    public function showAdminLogin()
    {
        return view('empresas.admin.login');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_admin' => true])) {
            return redirect()->route('empresas.admin.dashboard');
        }

        return back()->withErrors(['error' => 'Credenciais inválidas ou sem permissão!']);
    }
}
