# Script de Deploy Rápido - Instituto 30 de Setembro (PowerShell)
# Uso: .\scripts\deploy.ps1

Write-Host "🚀 Iniciando deploy do sistema..." -ForegroundColor Green

# 1. Limpar caches antigos
Write-Host "📦 Limpando caches..." -ForegroundColor Yellow
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 2. Otimizar para produção
Write-Host "⚡ Otimizando para produção..." -ForegroundColor Yellow
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Verificar migrations
Write-Host "🗄️ Verificando banco de dados..." -ForegroundColor Yellow
php artisan migrate --force

# 4. Executar seeders se necessário
Write-Host "🌱 Executando seeders..." -ForegroundColor Yellow
php artisan db:seed --force

# 5. Verificar sintaxe PHP
Write-Host "🔍 Verificando sintaxe PHP..." -ForegroundColor Yellow
Get-ChildItem -Path "app" -Filter "*.php" -Recurse | ForEach-Object {
    $result = php -l $_.FullName 2>&1
    if ($LASTEXITCODE -ne 0) {
        Write-Host "❌ Erro de sintaxe em: $($_.FullName)" -ForegroundColor Red
        Write-Host $result -ForegroundColor Red
    }
}

# 6. Verificar rotas
Write-Host "🛣️ Verificando rotas..." -ForegroundColor Yellow
php artisan route:list --compact

Write-Host "✅ Deploy concluído com sucesso!" -ForegroundColor Green
Write-Host "🌐 Sistema pronto para uso!" -ForegroundColor Green
