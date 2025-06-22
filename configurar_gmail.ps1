# Script para configurar Gmail SMTP no Laravel
# Execute este script após gerar sua senha de app no Gmail

Write-Host "=== CONFIGURAÇÃO GMAIL SMTP ===" -ForegroundColor Green
Write-Host ""

# Solicitar informações do usuário
$email = Read-Host "Digite seu email Gmail (ex: joao@gmail.com)"
$senhaApp = Read-Host "Digite sua senha de app do Gmail (ex: abcd efgh ijkl mnop)"

Write-Host ""
Write-Host "Configurando Gmail SMTP..." -ForegroundColor Yellow

# Backup do arquivo .env atual
Copy-Item .env .env.backup

# Ler o arquivo .env
$envContent = Get-Content .env

# Substituir as configurações de email
$envContent = $envContent -replace 'MAIL_HOST=.*', "MAIL_HOST=smtp.gmail.com"
$envContent = $envContent -replace 'MAIL_PORT=.*', "MAIL_PORT=587"
$envContent = $envContent -replace 'MAIL_USERNAME=.*', "MAIL_USERNAME=$email"
$envContent = $envContent -replace 'MAIL_PASSWORD=.*', "MAIL_PASSWORD=$senhaApp"
$envContent = $envContent -replace 'MAIL_FROM_ADDRESS=.*', "MAIL_FROM_ADDRESS=$email"
$envContent = $envContent -replace 'MAIL_FROM_NAME=.*', 'MAIL_FROM_NAME="Sistema Setembro 30"'

# Salvar o arquivo .env atualizado
$envContent | Set-Content .env

Write-Host ""
Write-Host "✅ Configuração Gmail concluída!" -ForegroundColor Green
Write-Host "📧 Email: $email" -ForegroundColor Cyan
Write-Host "🔒 Senha de App configurada" -ForegroundColor Cyan
Write-Host ""
Write-Host "Agora você pode testar a recuperação de senha!" -ForegroundColor Yellow
Write-Host "Os emails chegarão diretamente ao seu Gmail." -ForegroundColor Yellow 