<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    // FUNÇÃO PARA LOGAR
    public function auth(Request $request)
    {
        $credenciais = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Digite um email válido.',
            'password.required' => 'O campo senha é obrigatório.',
        ]);

        // Log para debug
        Log::info('Tentativa de login', ['email' => $request->email]);

        if (Auth::attempt($credenciais, $request->has('remember'))) {
            $request->session()->regenerate();
            
            Log::info('Login bem-sucedido', ['user_id' => Auth::id()]);
            
            return redirect()->intended('admin/dashboard');
        }

        Log::warning('Falha no login', ['email' => $request->email]);

        return redirect()
            ->back()
            ->withInput($request->only('email'))
            ->withErrors(['error' => 'Email ou senha incorretos.']);
    }

    public function loginForm(){
       return view('site.login');
    }

    
    //FUNÇÃO PARA LOGOUT
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.form');
    }


}
