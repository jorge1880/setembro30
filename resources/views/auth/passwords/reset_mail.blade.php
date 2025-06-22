<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nova Senha - Sistema Setembro 30</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #4CAF50; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 5px 5px; }
        .password-box { background: #fff; border: 2px solid #4CAF50; padding: 15px; margin: 20px 0; text-align: center; border-radius: 5px; }
        .password { font-size: 24px; font-weight: bold; color: #4CAF50; letter-spacing: 2px; }
        .warning { background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .steps { background: #e8f5e8; padding: 20px; margin: 20px 0; border-radius: 5px; }
        .step { margin: 10px 0; }
        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔐 Nova Senha de Acesso</h1>
            <p>Sistema Setembro 30</p>
        </div>
        
        <div class="content">
            <h2>Olá, {{ $user->nome }}!</h2>
            
            <p>Você solicitou uma nova senha para sua conta no Sistema Setembro 30.</p>
            
            <div class="password-box">
                <h3>📝 Sua nova senha é:</h3>
                <div class="password">{{ $novaSenha }}</div>
                <p><small>Copie esta senha exatamente como está escrita</small></p>
            </div>
            
            <div class="steps">
                <h3>📚 Próximos passos:</h3>
                <div class="step">1️⃣ Acesse o sistema: <a href="{{ url('/login') }}">{{ url('/login') }}</a></div>
                <div class="step">2️⃣ Use seu email: <strong>{{ $user->email }}</strong></div>
                <div class="step">3️⃣ Digite a nova senha: <strong>{{ $novaSenha }}</strong></div>
                <div class="step">4️⃣ Faça login e altere a senha por uma de sua preferência</div>
            </div>
            
            <div class="warning">
                <h3>⚠️ Importante:</h3>
                <ul>
                    <li>Esta senha é temporária e foi gerada automaticamente</li>
                    <li>Recomendamos alterá-la após o primeiro acesso</li>
                    <li>Mantenha sua senha segura e não a compartilhe</li>
                    <li>Se você não solicitou esta alteração, entre em contato conosco</li>
                </ul>
            </div>
            
            <p><strong>Precisa de ajuda?</strong> Entre em contato com o suporte técnico.</p>
        </div>
        
        <div class="footer">
            <p>Este email foi enviado automaticamente pelo Sistema Setembro 30.</p>
            <p>Não responda a este email. Para suporte, entre em contato com o administrador.</p>
        </div>
    </div>
</body>
</html> 