<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        return view('empresas.admin.dashboard');
    }

    // Logout area admin

    public function adminLogout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('empresas.dashboard.dashboard'); // 🔹 Redireciona para a rota desejada
    }
}
