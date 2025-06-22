<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\ResetPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'O campo E-mail é obrigatório.',
            'email.email' => 'Por favor, insira um endereço de e-mail válido.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'Nenhuma conta encontrada com este e-mail.']);
        }

        try {
            DB::beginTransaction();

            // Gerar nova senha
            $novaSenha = Str::random(10);
            $user->password = Hash::make($novaSenha);
            $user->save();

            // Enviar email com a nova senha
            $emailEnviado = Mail::to($user->email)->send(new ResetPasswordMail($user, $novaSenha));

            DB::commit();

            if ($emailEnviado) {
                return redirect()->route('login')->with('success', 
                    'Uma nova senha foi enviada para o seu e-mail. Verifique sua caixa de entrada.'
                );
            } else {
                DB::rollback();
                return redirect()->back()->with('error', 
                    'Não foi possível enviar o e-mail de recuperação. Tente novamente mais tarde.'
                );
            }
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Erro na recuperação de senha: ' . $e->getMessage());
            
            return redirect()->back()->with('error', 
                'Ocorreu um erro ao redefinir sua senha. Tente novamente.'
            );
        }
    }

    /**
     * Identifica o provedor de email
     */
    private function getEmailProvider($email)
    {
        $domain = substr(strrchr($email, "@"), 1);
        
        $providers = [
            'gmail.com' => 'Gmail',
            'outlook.com' => 'Outlook',
            'hotmail.com' => 'Outlook',
            'yahoo.com' => 'Yahoo',
            'yahoo.com.br' => 'Yahoo',
            'live.com' => 'Outlook',
            'icloud.com' => 'iCloud',
            'protonmail.com' => 'ProtonMail'
        ];

        return $providers[$domain] ?? $domain;
    }
} 