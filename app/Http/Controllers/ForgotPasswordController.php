<?php

namespace App\Http\Controllers;

use App\Models\TomadorServico;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function forgotPassword()
    {
        return view('login.forgotPassword');
    }

    public function forgotPasswordSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ],[
            'email.required' => 'O Campo E-mail deve ser preenchido!',
            'email.email' => 'Necessário Informar E-mail válido!',
        ]);

        // Verificar se o usuário existe na tabela users
        if (User::where('email', $request->email)->first()) {

        }
        // Verficar se o usuário existe na tabela tomadores de servicos
        elseif (TomadorServico::where('email', $request->email)->first()) {

        }

        else {
            return back()->withInput()->with('error', 'E-mail não encontrado!');
        };

        try {

            // Salvar token recuperar senha e enviar e-mail
            $status = Password::sendResetLink(
                $request->only('email')
            );

            return redirect()->route('login.index')->with('success', 'E-mail de recuperação foi enviado!');

        } catch (Exception $e) {

            return back()->withInput()->with('error', 'Tente novamente mais tarde!');
        }
    }

    public function resetPassword(Request $request)
    {
        dd($request->token);
    }
}
