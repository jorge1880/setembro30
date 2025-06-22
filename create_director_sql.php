<?php

// Configurações do banco de dados
$host = 'localhost';
$dbname = 'setembro30';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar se o usuário já existe
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute(['diretor@setembro30.com']);
    
    if ($stmt->rowCount() == 0) {
        // Criar o usuário
        $hashedPassword = password_hash('123456', PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("INSERT INTO users (nome, email, password, nivel, imagem, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
        $stmt->execute([
            'Diretor Geral',
            'diretor@setembro30.com',
            $hashedPassword,
            'diretor_geral',
            null
        ]);
        
        echo "Usuário diretor geral criado com sucesso!\n";
        echo "Email: diretor@setembro30.com\n";
        echo "Senha: 123456\n";
    } else {
        echo "Usuário diretor geral já existe!\n";
        echo "Email: diretor@setembro30.com\n";
        echo "Senha: 123456\n";
    }
    
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage() . "\n";
} 