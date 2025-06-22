# Guia de Desenvolvimento - Instituto 30 de Setembro

## 🚀 Configuração Inicial

### Pré-requisitos
- PHP 8.0+
- Composer
- MySQL 8.0+
- Node.js (opcional, para assets)

### Instalação
```bash
# Clonar repositório
git clone [URL_DO_REPOSITORIO]
cd setembro30

# Instalar dependências
composer install

# Configurar ambiente
cp .env.example .env
php artisan key:generate

# Configurar banco de dados no .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=setembro30
DB_USERNAME=root
DB_PASSWORD=

# Executar migrations e seeders
php artisan migrate --seed

# Iniciar servidor
php artisan serve
```

## 📁 Estrutura do Projeto

```
setembro30/
├── app/
│   ├── Http/Controllers/    # Controllers
│   ├── Models/             # Models Eloquent
│   ├── Policies/           # Políticas de autorização
│   └── Services/           # Serviços
├── database/
│   ├── migrations/         # Migrações
│   └── seeders/           # Seeders
├── resources/
│   └── views/             # Views Blade
├── routes/
│   └── web.php           # Rotas web
└── storage/
    └── app/public/       # Arquivos públicos
```

## 🔐 Usuários Padrão

### Diretor Geral
- Email: `diretor@setembro30.com`
- Senha: `123456`

### Professor
- Email: `professor@setembro30.com`
- Senha: `123456`

### Aluno
- Email: `aluno@setembro30.com`
- Senha: `123456`

## 🛠️ Comandos Úteis

### Desenvolvimento
```bash
# Criar controller
php artisan make:controller NomeController --resource

# Criar model com migration
php artisan make:model NomeModel -m

# Criar policy
php artisan make:policy NomePolicy --model=NomeModel

# Criar request
php artisan make:request NomeRequest

# Limpar caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Deploy
```bash
# Script de deploy automático
./scripts/deploy.sh

# Ou manualmente
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
```

## 🎨 Frontend

### CSS Framework
- Materialize CSS

### Estrutura de Views
- Layout principal: `resources/views/site/layout.blade.php`
- Admin: `resources/views/admin/`
- Auth: `resources/views/auth/`

### Assets
- CSS: `public/css/`
- JS: `public/js/`
- Imagens: `public/img/`

## 🔍 Debugging

### Logs
- Arquivo: `storage/logs/laravel.log`
- Comando: `tail -f storage/logs/laravel.log`

### Debug
```php
// Debug rápido
dd($variavel);
dump($variavel);

// Debug em views
{{ dd($variavel) }}
```

## 📊 Banco de Dados

### Migrations
```bash
# Criar migration
php artisan make:migration create_tabela_table

# Executar migrations
php artisan migrate

# Reverter última migration
php artisan migrate:rollback

# Reset completo
php artisan migrate:fresh --seed
```

### Seeders
```bash
# Executar seeders
php artisan db:seed

# Executar seeder específico
php artisan db:seed --class=NomeSeeder
```

## 🔒 Segurança

### Autenticação
- Middleware `auth` para rotas protegidas
- Policies para autorização específica
- Validação com Form Requests

### Validação
```php
// Exemplo de validação
$request->validate([
    'nome' => 'required|string|max:255',
    'email' => 'required|email|unique:users',
    'password' => 'required|min:6|confirmed',
]);
```

## 🚀 Deploy

### Railway (Recomendado)
1. Conectar repositório GitHub
2. Configurar variáveis de ambiente
3. Deploy automático

### Variáveis de Ambiente Necessárias
```
APP_NAME="Instituto 30 de Setembro"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seu-dominio.railway.app

DB_CONNECTION=mysql
DB_HOST=...
DB_PORT=3306
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...

MAIL_MAILER=smtp
MAIL_HOST=...
MAIL_PORT=587
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=...
MAIL_FROM_NAME="${APP_NAME}"
```

## 📝 Convenções

### Nomenclatura
- Controllers: PascalCase + Controller
- Models: PascalCase singular
- Views: kebab-case
- Routes: kebab-case
- Migrations: snake_case

### Código
- PSR-4 para autoloading
- PSR-12 para estilo de código
- Namespaces completos
- Documentação PHPDoc

## 🐛 Troubleshooting

### Problemas Comuns

#### Erro de permissão
```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

#### Erro de cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

#### Erro de banco
```bash
php artisan migrate:fresh --seed
```

## 📞 Suporte

Para dúvidas ou problemas:
1. Verificar logs em `storage/logs/`
2. Consultar documentação Laravel
3. Verificar issues do projeto
