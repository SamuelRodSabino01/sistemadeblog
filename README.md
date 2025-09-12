# Sistema de Blog Laravel

Um sistema completo de blog desenvolvido em Laravel com painel administrativo, sistema de comentários, upload de imagens e interface responsiva.

## 🚀 Funcionalidades

### Frontend Público
- ✅ Página inicial com estatísticas e posts em destaque
- ✅ Listagem de posts com paginação
- ✅ Visualização individual de posts
- ✅ Sistema de comentários
- ✅ Busca por posts
- ✅ Filtros por categoria e tags
- ✅ Design responsivo com Tailwind CSS

### Painel Administrativo
- ✅ Dashboard com estatísticas
- ✅ Gerenciamento completo de posts (CRUD)
- ✅ Gerenciamento de categorias
- ✅ Gerenciamento de tags
- ✅ Moderação de comentários
- ✅ Upload e redimensionamento automático de imagens
- ✅ Sistema de posts em destaque
- ✅ Editor de conteúdo avançado

### Sistema de Autenticação
- ✅ Login e registro de usuários
- ✅ Middleware de proteção para área administrativa
- ✅ Controle de acesso baseado em roles

## 🛠️ Tecnologias Utilizadas

- **Backend:** Laravel 10.x
- **Frontend:** Blade Templates + Tailwind CSS
- **Banco de Dados:** MySQL/SQLite
- **Upload de Imagens:** Intervention Image
- **Autenticação:** Laravel Breeze
- **Icons:** Font Awesome

## 📋 Pré-requisitos

- PHP >= 8.1
- Composer
- Node.js >= 16.x
- NPM ou Yarn
- MySQL ou SQLite

## 🔧 Instalação

1. **Clone o repositório:**
```bash
git clone <url-do-repositorio>
cd sistemadeblog
```

2. **Instale as dependências PHP:**
```bash
composer install
```

3. **Instale as dependências Node.js:**
```bash
npm install
```

4. **Configure o ambiente:**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure o banco de dados no arquivo `.env`:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistemadeblog
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

6. **Execute as migrations:**
```bash
php artisan migrate
```

7. **Crie o link simbólico para storage:**
```bash
php artisan storage:link
```

8. **Compile os assets:**
```bash
npm run build
```

9. **Inicie o servidor:**
```bash
php artisan serve
```

## ✨ Funcionalidades Implementadas

### 🔐 Sistema de Autenticação e Autorização
- **Diferenciação automática** entre usuários administradores e comuns
- **Middleware de proteção** para rotas administrativas
- **Redirecionamento inteligente** baseado no tipo de usuário após login
- **Campo `is_admin`** na tabela users para controle de permissões

### 📊 Dashboards Personalizados
- **Dashboard Administrativo**: Acesso completo ao gerenciamento do sistema
- **Dashboard do Usuário**: Interface personalizada com estatísticas pessoais
- **Estatísticas em tempo real**: Posts recentes, comentários, atividades

### 🛡️ Segurança
- **AdminMiddleware** ativo protegendo rotas administrativas
- **Verificação de permissões** em tempo real
- **Controle de acesso** baseado em roles (admin/user)

## 🔑 Credenciais para Teste

### 👨‍💼 Usuário Administrador
- **Email:** admin@blog.com
- **Senha:** admin123
- **Acesso:** Painel administrativo completo (`/admin`)
- **Permissões:** Gerenciar posts, categorias, tags, comentários e usuários

### 👤 Usuário Comum
- **Email:** user@blog.com
- **Senha:** user123
- **Acesso:** Dashboard personalizado (`/user/dashboard`)
- **Permissões:** Visualizar blog, comentar posts, gerenciar perfil

> **Nota:** O sistema diferencia automaticamente entre administradores e usuários comuns através do campo `is_admin` na tabela users. Estas credenciais são para ambiente de desenvolvimento/teste. Em produção, altere as senhas e remova estas informações.

## 🔐 Sistema de Permissões

### Diferenciação de Usuários
- **Administradores** (`is_admin = true`): Acesso completo ao painel administrativo
- **Usuários Comuns** (`is_admin = false`): Acesso limitado ao dashboard do usuário

### Middleware de Segurança
- `AdminMiddleware`: Protege rotas administrativas, verificando o campo `is_admin`
- Redirecionamento automático baseado no tipo de usuário após login

### Dashboards Separados
- **Admin Dashboard** (`/admin`): Estatísticas completas, gerenciamento de conteúdo
- **User Dashboard** (`/user/dashboard`): Visualização de atividades pessoais, posts recentes

## 📁 Estrutura do Projeto

```
sistemadeblog/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Controllers do painel admin
│   │   ├── BlogController.php
│   │   ├── CommentController.php
│   │   └── UserDashboardController.php  # Controller do dashboard do usuário
│   ├── Models/
│   │   ├── Post.php
│   │   ├── Category.php
│   │   ├── Tag.php
│   │   ├── Comment.php
│   │   └── User.php        # Inclui campo is_admin
│   ├── Helpers/
│   │   └── ImageHelper.php  # Helper para upload de imagens
│   └── Middleware/
│       └── AdminMiddleware.php  # Middleware de proteção admin
├── resources/views/
│   ├── admin/              # Views do painel administrativo
│   ├── user/               # Views do dashboard do usuário
│   ├── blog/               # Views do frontend público
│   ├── auth/               # Views de autenticação
│   └── layouts/            # Layouts base
├── database/migrations/    # Migrations do banco
├── config/images.php       # Configurações de upload
└── public/storage/images/  # Diretório de imagens
```

## 🎨 Configuração de Imagens

O sistema possui configurações flexíveis para upload de imagens em `config/images.php`:

- **Tamanho máximo:** 5MB
- **Formatos aceitos:** JPEG, PNG, GIF, WebP
- **Redimensionamento automático** por tipo de conteúdo
- **Geração automática de thumbnails**
- **Qualidade configurável** (padrão: 85%)

## 🚦 Rotas Principais

### Frontend Público
- `/` - Página inicial
- `/blog` - Listagem de posts
- `/blog/{post}` - Visualização de post
- `/category/{category}` - Posts por categoria
- `/tag/{tag}` - Posts por tag
- `/search` - Busca de posts

### Painel Administrativo
- `/admin` - Dashboard
- `/admin/posts` - Gerenciar posts
- `/admin/categories` - Gerenciar categorias
- `/admin/tags` - Gerenciar tags
- `/admin/comments` - Moderar comentários

## 🔒 Segurança

- Middleware de autenticação para área administrativa
- Validação de uploads de imagem
- Sanitização de conteúdo
- Proteção CSRF
- Validação de formulários

## 📱 Responsividade

O sistema é totalmente responsivo, adaptando-se a:
- 📱 Dispositivos móveis (320px+)
- 📱 Tablets (768px+)
- 💻 Desktops (1024px+)
- 🖥️ Telas grandes (1280px+)

## 🤝 Contribuição

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request


## 👨‍💻 Desenvolvedor

**Samuel Rodrigues Sabino**  
Desenvolvedor Full Stack & Designer UI/UX

🌐 **Portfólio**: [https://samuelrodsabino.vercel.app/](https://samuelrodsabino.vercel.app/)
