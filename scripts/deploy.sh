#!/bin/bash

# Script de Deploy Rápido - Instituto 30 de Setembro
# Uso: ./scripts/deploy.sh

echo "🚀 Iniciando deploy do sistema..."

# 1. Limpar caches antigos
echo "📦 Limpando caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 2. Otimizar para produção
echo "⚡ Otimizando para produção..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Verificar migrations
echo "🗄️ Verificando banco de dados..."
php artisan migrate --force

# 4. Executar seeders se necessário
echo "🌱 Executando seeders..."
php artisan db:seed --force

# 5. Verificar permissões de storage
echo "🔐 Configurando permissões..."
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/

# 6. Verificar sintaxe PHP
echo "🔍 Verificando sintaxe PHP..."
find app/ -name "*.php" -exec php -l {} \;

# 7. Verificar rotas
echo "🛣️ Verificando rotas..."
php artisan route:list --compact

echo "✅ Deploy concluído com sucesso!"
echo "🌐 Sistema pronto para uso!"
