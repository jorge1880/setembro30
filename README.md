# 🏫 Sistema de Gestão Escolar - Instituto 30 de Setembro

Sistema completo de gestão escolar desenvolvido em Laravel 9 para o Instituto 30 de Setembro.

## 🚀 Características

- **Dashboard Administrativo** com gráficos dinâmicos
- **Gestão de Cursos, Turmas e Disciplinas**
- **Sistema de Aulas e Materiais**
- **Gestão de Professores e Alunos**
- **Sistema de Posts e Fóruns**
- **Página "Sobre Nós" Interativa**
- **Sistema de Autenticação e Autorização**
- **Interface Responsiva com Materialize CSS**

## 🛠️ Tecnologias

- **Backend:** Laravel 9, PHP 8.0+
- **Frontend:** Blade Templates, Materialize CSS, JavaScript
- **Banco de Dados:** MySQL 8.0+
- **Autenticação:** Laravel Sanctum
- **Deploy:** Railway (configurado)

## 📋 Pré-requisitos

- PHP 8.0 ou superior
- Composer
- MySQL 8.0 ou superior
- Git

## ⚡ Instalação Rápida

### 1. Clonar o repositório
```bash
git clone [URL_DO_REPOSITORIO]
cd setembro30
```

### 2. Instalar dependências
```bash
composer install
```

### 3. Configurar ambiente
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configurar banco de dados
Edite o arquivo `.env` com suas configurações:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=setembro30
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Executar migrations e seeders
```bash
php artisan migrate --seed
```

### 6. Iniciar servidor
```bash
php artisan serve
```

## 🔐 Usuários Padrão

| Tipo | Email | Senha |
|------|-------|-------|
| **Diretor Geral** | `diretor@setembro30.com` | `123456` |
| **Professor** | `professor@setembro30.com` | `123456` |
| **Aluno** | `aluno@setembro30.com` | `123456` |

## 🎯 Ambiente de Desenvolvimento Otimizado

Este projeto está configurado com um ambiente de desenvolvimento **super otimizado**:

### ✨ Extensões Recomendadas
- **Laravel Extension Pack** - Suporte completo ao Laravel
- **PHP Intelephense** - IntelliSense avançado para PHP
- **Laravel Blade Snippets** - Snippets para Blade
- **GitLens** - Git supercharged
- **Material Icon Theme** - Ícones bonitos
- **One Dark Pro** - Tema escuro elegante

### 🚀 Atalhos de Teclado
| Atalho | Ação |
|--------|------|
| `Ctrl+Shift+L` | Iniciar servidor Laravel |
| `Ctrl+Shift+C` | Limpar todos os caches |
| `Ctrl+Shift+M` | Executar migrations |
| `Ctrl+Shift+F` | Migrate fresh + seed |
| `Ctrl+Shift+R` | Listar rotas |
| `Ctrl+Shift+T` | Abrir Tinker |
| `Ctrl+Shift+D` | Criar controller |
| `Ctrl+Shift+O` | Criar model |
| `Ctrl+Shift+P` | Criar policy |
| `Ctrl+Shift+Q` | Criar request |

### 📝 Snippets Disponíveis
Digite `laravel-` seguido de:
- `controller` - Controller completo com CRUD
- `model` - Model com relacionamentos
- `migration` - Migration básica
- `form` - Formulário Blade com validação
- `route` - Rota Laravel
- `policy` - Policy completa

### 🎨 Formatação Automática
- **Prettier** configurado para formatação automática
- **EditorConfig** para consistência entre editores
- **PHP CodeSniffer** para padrões PSR-12

## 🚀 Deploy

### Railway (Recomendado)
1. Conectar repositório GitHub ao Railway
2. Configurar variáveis de ambiente
3. Deploy automático

### Script de Deploy
```bash
# Deploy automático
./scripts/deploy.sh

# Ou no Windows
.\scripts\deploy.ps1
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
├── .vscode/              # Configurações do editor
├── scripts/              # Scripts úteis
└── docs/                 # Documentação
```

## 🔧 Comandos Úteis

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
```

### Manutenção
```bash
# Limpar caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Otimizar para produção
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

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

## 📚 Documentação

- [Guia de Desenvolvimento](docs/DEVELOPMENT.md)
- [Documentação Laravel](https://laravel.com/docs)
- [Materialize CSS](https://materializecss.com/)

## 🤝 Contribuição

1. Fork o projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## 📞 Suporte

Para dúvidas ou problemas:
1. Verificar logs em `storage/logs/`
2. Consultar documentação em `docs/DEVELOPMENT.md`
3. Abrir uma issue no repositório

---

**Desenvolvido com ❤️ para o Instituto 30 de Setembro**
