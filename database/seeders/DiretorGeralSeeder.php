<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DiretorGeralSeeder extends Seeder
{
    public function run()
    {
        // Usuário Diretor Geral 1
        User::firstOrCreate(
            ['email' => 'diretor.geral@escola.com'],
            [
                'nome' => 'Diretor Geral Principal',
                'nivel' => 'diretor_geral',
                'password' => bcrypt('senha123'),
                'imagem' => null,
            ]
        );

        // Usuário Diretor Geral 2
        User::firstOrCreate(
            ['email' => 'diretor.adjunto@escola.com'],
            [
                'nome' => 'Diretor Adjunto',
                'nivel' => 'diretor_geral',
                'password' => bcrypt('senha123'),
                'imagem' => null,
            ]
        );
    }
} 