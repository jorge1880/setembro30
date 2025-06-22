# 🚀 Deploy no Railway - Instituto 30 de Setembro

## 📋 Pré-requisitos
- Conta no GitHub
- Conta no Railway (gratuita)

## 🔧 Passos para Deploy

### 1. Preparar o Projeto
- ✅ Arquivo `railway.json` criado
- ✅ Arquivo `Procfile` criado
- ✅ Projeto no GitHub

### 2. Criar Conta no Railway
1. Acesse: https://railway.app
2. Faça login com GitHub
3. Clique em "New Project"

### 3. Conectar ao GitHub
1. Selecione "Deploy from GitHub repo"
2. Escolha o repositório do projeto
3. Clique em "Deploy Now"

### 4. Configurar Base de Dados
1. No projeto Railway, clique em "New"
2. Selecione "Database" → "MySQL"
3. Anote as credenciais fornecidas

### 5. Configurar Variáveis de Ambiente
No Railway, vá em "Variables" e adicione:

```env
APP_NAME="Instituto 30 de Setembro"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seu-projeto.railway.app

DB_CONNECTION=mysql
DB_HOST=seu-host-mysql.railway.app
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=sua-senha-mysql

CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

### 6. Gerar APP_KEY
1. No terminal do Railway, execute:
```bash
php artisan key:generate
```

### 7. Executar Migrações
```bash
php artisan migrate
```

### 8. Configurar Storage
```bash
php artisan storage:link
```

## 🌐 Acesso
- **URL**: https://seu-projeto.railway.app
- **Admin**: https://seu-projeto.railway.app/admin/dashboard

## 📞 Suporte
Se precisar de ajuda, consulte a documentação do Railway ou entre em contacto.

---
**Nota**: O Railway oferece 500 horas gratuitas por mês, suficiente para projetos pequenos.

## **🎯 Próximos Passos:**

### **1. Subir para GitHub**
Primeiro, precisa colocar o projeto no GitHub:

```bash
# Configurar Git
git config --global user.name "Seu Nome"
git config --global user.email "seu-email@gmail.com"

# Inicializar repositório
git init
git add .
git commit -m "Primeiro commit - Sistema Instituto 30 de Setembro"
git branch -M main

# Conectar ao GitHub (substitua SEU_USUARIO pelo seu username)
git remote add origin https://github.com/SEU_USUARIO/setembro30.git
git push -u origin main
```

### **2. Fazer Deploy no Railway**
1. Acesse: https://railway.app
2. Faça login com GitHub
3. Clique "New Project" → "Deploy from GitHub repo"
4. Escolha o repositório
5. Siga as instruções do arquivo `DEPLOY.md`

## **✅ Vantagens do Railway:**
- **Gratuito** para começar
- **Deploy automático** quando fizer push no GitHub
- **SSL automático**
- **Base de dados MySQL incluída**
- **Domínio gratuito**
- **Muito simples** de configurar

## **🚀 Quer que eu te ajude com algum passo específico?**

Posso te guiar em:
- Configurar o GitHub
- Fazer o deploy no Railway
- Configurar a base de dados
- Resolver problemas

**Qual parte quer começar primeiro?** 

## **🔧 Alternativa: Usar o Git Bash**

Se preferir não reiniciar agora, pode usar o **Git Bash** que vem com a instalação:

1. **Procure por "Git Bash"** no menu iniciar
2. **Abra o Git Bash**
3. **Navegue para a pasta**:
   ```bash
   cd /c/laragon/www/setembro30
   ```
4. **Execute os comandos** que vou te dar

## **📋 Comandos para executar (quando o Git estiver funcionando):**

```bash
# Configurar Git
git config --global user.name "Seu Nome"
git config --global user.email "seu-email@gmail.com"

# Inicializar repositório
git init
git add .
git commit -m "Primeiro commit - Sistema Instituto 30 de Setembro"
git branch -M main

# Conectar ao GitHub (substitua SEU_USUARIO pelo seu username)
git remote add origin https://github.com/SEU_USUARIO/setembro30.git
git push -u origin main
```

## **🌐 Criar repositório no GitHub:**

1. Acesse: https://github.com
2. Clique **"New repository"**
3. **Name**: `setembro30`
4. **Description**: `Sistema de gestão escolar - Instituto 30 de Setembro`
5. **Private** (recomendado)
6. **NÃO** marque "Add a README"
7. Clique **"Create repository"**

**Qual opção prefere?**
- A) Reiniciar o computador e usar PowerShell
- B) Usar Git Bash
- C) Tentar outra solução

**Me diga qual escolheu e quando estiver pronto!** 🚀 