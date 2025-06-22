#!/bin/bash

# Pre-commit hook para verificar código
echo "🔍 Verificando código antes do commit..."

# Verificar sintaxe PHP
echo "📝 Verificando sintaxe PHP..."
find app/ -name "*.php" -exec php -l {} \;
if [ $? -ne 0 ]; then
    echo "❌ Erro de sintaxe PHP encontrado!"
    exit 1
fi

# Verificar padrões de código (se PHPCS estiver instalado)
if command -v phpcs &> /dev/null; then
    echo "🎨 Verificando padrões de código..."
    phpcs --standard=phpcs.xml
    if [ $? -ne 0 ]; then
        echo "❌ Violações de padrão de código encontradas!"
        exit 1
    fi
fi

# Verificar se há arquivos .env no commit
if git diff --cached --name-only | grep -q "\.env$"; then
    echo "⚠️  Arquivo .env detectado no commit!"
    echo "   Considere usar .env.example em vez de .env"
    read -p "Continuar mesmo assim? (y/N): " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        exit 1
    fi
fi

echo "✅ Verificação concluída com sucesso!"
exit 0
