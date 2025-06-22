<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

try {
    $user = User::firstOrCreate(
        ['email' => 'diretor@setembro30.com'],
        [
            'nome' => 'Diretor Geral',
            'nivel' => 'diretor_geral',
            'password' => Hash::make('123456'),
            'imagem' => null,
        ]
    );

    echo "Usuário diretor geral criado com sucesso!\n";
    echo "Email: diretor@setembro30.com\n";
    echo "Senha: 123456\n";
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
} 