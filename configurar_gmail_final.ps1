# Configuração Gmail SMTP Final
Write-Host "=== CONFIGURAÇÃO GMAIL SMTP ===" -ForegroundColor Green
Write-Host ""

# Solicitar email e senha de app
$email = Read-Host "Digite seu email Gmail (ex: joao@gmail.com)"
$senhaApp = Read-Host "Digite sua senha de app do Gmail"

Write-Host ""
Write-Host "Configurando..." -ForegroundColor Yellow

# Atualizar configurações
$envContent = Get-Content .env
$envContent = $envContent -replace 'MAIL_USERNAME=.*', "MAIL_USERNAME=$email"
$envContent = $envContent -replace 'MAIL_PASSWORD=.*', "MAIL_PASSWORD=$senhaApp"
$envContent = $envContent -replace 'MAIL_FROM_ADDRESS=.*', "MAIL_FROM_ADDRESS=$email"
$envContent = $envContent -replace 'MAIL_FROM_NAME=.*', 'MAIL_FROM_NAME="Sistema Setembro 30"'

$envContent | Set-Content .env

Write-Host ""
Write-Host "✅ Gmail configurado!" -ForegroundColor Green
Write-Host "📧 Email: $email" -ForegroundColor Cyan
Write-Host ""
Write-Host "Agora teste a recuperação de senha!" -ForegroundColor Yellow
Write-Host "O email chegará na sua caixa postal!" -ForegroundColor Yellow 