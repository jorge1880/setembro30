<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $novaSenha;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $novaSenha)
    {
        $this->user = $user;
        $this->novaSenha = $novaSenha;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('🔐 Nova senha de acesso - Sistema Setembro 30')
                    ->view('auth.passwords.reset_mail')
                    ->with([
                        'user' => $this->user,
                        'novaSenha' => $this->novaSenha
                    ]);
    }
} 