<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateDirectorUser extends Command
{
    protected $signature = 'user:create-director';
    protected $description = 'Criar usuário diretor geral';

    public function handle()
    {
        $user = User::firstOrCreate(
            ['email' => 'diretor@setembro30.com'],
            [
                'nome' => 'Diretor Geral',
                'nivel' => 'diretor_geral',
                'password' => Hash::make('123456'),
                'imagem' => null,
            ]
        );

        $this->info('Usuário diretor geral criado com sucesso!');
        $this->info('Email: diretor@setembro30.com');
        $this->info('Senha: 123456');
    }
} 