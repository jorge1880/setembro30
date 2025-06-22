# 🚀 Guia Completo de Deploy - Instituto Politécnico 30 de Setembro

## 📋 Opções de Hospedagem

### 1. 🚂 Railway (RECOMENDADO - Gratuito)
**Vantagens:** Fácil, gratuito, automático
**Custo:** Gratuito (500h/mês)

**Passos:**
1. Acesse [railway.app](https://railway.app)
2. Login com GitHub
3. "New Project" → "Deploy from GitHub"
4. Selecione seu repositório
5. Adicione MySQL Database
6. Configure variáveis de ambiente
7. Deploy automático

### 2. 🎯 Heroku (Pago)
**Vantagens:** Confiável, escalável
**Custo:** $7/mês (Hobby Dyno)

**Passos:**
1. Instale Heroku CLI
2. `heroku create seu-app`
3. `heroku addons:create cleardb:ignite` (MySQL)
4. Configure variáveis de ambiente
5. `git push heroku main`

### 3. 🌐 Vercel (Gratuito)
**Vantagens:** Muito rápido, gratuito
**Custo:** Gratuito

**Passos:**
1. Acesse [vercel.com](https://vercel.com)
2. Importe do GitHub
3. Configure variáveis
4. Deploy automático

### 4. ☁️ DigitalOcean (Pago)
**Vantagens:** Controle total
**Custo:** $5/mês

**Passos:**
1. Crie um Droplet
2. Configure LAMP stack
3. Upload dos arquivos
4. Configure domínio

## 🔧 Configurações Comuns

### Variáveis de Ambiente (.env)
```env
APP_NAME="Instituto Politécnico 30 de Setembro"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://seu-dominio.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=setembro30
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu-email@gmail.com
MAIL_PASSWORD=sua-senha-de-app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=seu-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Comandos de Instalação
```bash
composer install --optimize-autoloader --no-dev
php artisan key:generate
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🎯 Recomendação Final

**Para começar:** Use o **Railway**
- Gratuito
- Fácil de configurar
- Deploy automático
- Suporte a MySQL
- SSL automático

**Para produção:** Use o **Heroku**
- Mais confiável
- Melhor performance
- Suporte técnico
- Escalabilidade

## ✅ Checklist Final

- [x] Projeto testado localmente
- [x] Todas as funcionalidades funcionando
- [x] Banco de dados configurado
- [x] Email configurado
- [x] Upload de arquivos funcionando
- [x] Cache otimizado
- [x] Segurança verificada

## 🎉 Status: PRONTO PARA PRODUÇÃO!

O projeto está 100% funcional e pronto para ser hospedado! 