# 🚂 Deploy no Railway - Instituto Politécnico 30 de Setembro

## 📋 Pré-requisitos
- Conta no GitHub (gratuita)
- Conta no Railway (gratuita)
- Projeto já está no GitHub

## 🔧 Passo a Passo

### 1. Preparar o Projeto
```bash
# Certifique-se de que o projeto está no GitHub
git add .
git commit -m "Projeto pronto para produção"
git push origin main
```

### 2. Conectar ao Railway
1. Acesse [railway.app](https://railway.app)
2. Faça login com sua conta GitHub
3. Clique em "New Project"
4. Selecione "Deploy from GitHub repo"
5. Escolha seu repositório `setembro30`

### 3. Configurar Variáveis de Ambiente
No Railway, vá em "Variables" e adicione:

```env
APP_NAME="Instituto Politécnico 30 de Setembro"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://seu-app.railway.app

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=seu-host-mysql.railway.app
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=sua-senha-mysql

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu-email@gmail.com
MAIL_PASSWORD=sua-senha-de-app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=seu-email@gmail.com
MAIL_FROM_NAME="Instituto Politécnico 30 de Setembro"
```

### 4. Adicionar Banco MySQL
1. No Railway, clique em "New"
2. Selecione "Database" → "MySQL"
3. Aguarde a criação
4. Copie as credenciais para o `.env`

### 5. Configurar Build Commands
No Railway, vá em "Settings" → "Build & Deploy" e configure:

**Build Command:**
```bash
composer install --optimize-autoloader --no-dev
```

**Start Command:**
```bash
php artisan key:generate && php artisan migrate --force && php artisan storage:link && php artisan config:cache && php artisan route:cache && php artisan view:cache && php -S 0.0.0.0:$PORT -t public
```

### 6. Deploy
1. Clique em "Deploy Now"
2. Aguarde o build completar
3. Acesse a URL gerada

### 7. Configurar Domínio Personalizado (Opcional)
1. Vá em "Settings" → "Domains"
2. Adicione seu domínio
3. Configure os registros DNS

## ✅ Verificações Pós-Deploy
- [ ] Site acessível
- [ ] Login funcionando
- [ ] Recuperação de senha funcionando
- [ ] Upload de imagens funcionando
- [ ] Todas as funcionalidades testadas

## 💰 Custos
- **Gratuito**: 500 horas/mês
- **Pago**: $5/mês para mais recursos

## 🔧 Troubleshooting
- **Erro 500**: Verificar logs no Railway
- **Banco não conecta**: Verificar credenciais do MySQL
- **Email não funciona**: Verificar configurações Gmail 