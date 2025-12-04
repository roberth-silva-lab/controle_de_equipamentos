# 📦 Sistema de Controle de Equipamentos

Um aplicativo **Laravel 12** para gerenciar empréstimo de equipamentos entre alunos e professores.

---

## 🎯 Visão Geral

O sistema permite:
- **Cadastro e controle** de equipamentos com patrimônio, quantidade e status
- **Gerenciamento de usuários** (alunos e professores) com matrícula única
- **Empréstimos** com regras de negócio: alunos pegam por 15 dias, professores por 30 dias
- **Rastreamento** de devoluções com detecção de atrasos
- **Relatórios filtrados** por status, tipo de usuário e empréstimos ativos/devolvidos

---

## 🛠 Stack Tecnológico

| Componente | Versão | Descrição |
|-----------|--------|-----------|
| **PHP** | 8.3+ | Linguagem base |
| **Laravel** | 12 | Framework web |
| **MySQL/MariaDB** | 5.7+ | Banco de dados |
| **Blade** | Nativa | Template engine |
| **Bootstrap** | 5 (CDN) | UI framework |
| **Tailwind CSS** | 3 | Utility-first CSS (opcional) |

---

## 🚀 Quickstart

### 1. Clonar e Instalar
```bash
git clone <seu-repo> controle-equipamentos
cd controle-equipamentos
composer install
npm install
```

### 2. Configurar Ambiente
```bash
cp .env.example .env
php artisan key:generate
# Edite .env e configure DB_CONNECTION, DB_DATABASE, etc.
```

### 3. Executar Migrações e Seeders
```bash
php artisan migrate:fresh --seed
```

### 4. Iniciar Servidor
```bash
php artisan serve
# Em outro terminal:
npm run dev
```

Acesse: **http://localhost:8000**

---

## 📂 Estrutura do Projeto

```
controle-equipamentos/
├── app/
│   ├── Http/Controllers/
│   │   ├── UsuarioController.php        # CRUD de usuários
│   │   ├── EquipamentoController.php    # CRUD e relatório de equipamentos
│   │   └── EmprestimoController.php     # Empréstimos com validações
│   ├── Models/
│   │   ├── Usuario.php                  # Usuário (aluno/professor)
│   │   ├── Equipamento.php              # Equipamento (quantidade, status)
│   │   └── Emprestimo.php               # Relação empréstimo
│   └── Providers/
├── database/
│   ├── migrations/                      # Schemas de tabelas
│   ├── factories/                       # Factories para testes
│   └── seeders/                         # Seeders com dados iniciais
├── resources/
│   ├── views/
│   │   ├── layouts/app.blade.php        # Layout global (cores centralizadas)
│   │   ├── usuarios/                    # Views de usuários
│   │   ├── equipamentos/                # Views de equipamentos
│   │   └── emprestimos/                 # Views de empréstimos
│   ├── css/app.css                      # Estilos globais
│   └── js/app.js                        # Scripts globais
├── routes/web.php                       # Rotas do aplicativo
├── .env.example                         # Template de variáveis de ambiente
└── .gitignore                           # Arquivos ignorados no Git
```

---

## 📋 Entidades Principais

### Usuario
- `id`: Chave primária
- `nome`: Nome completo
- `matricula`: String única (máx 4 caracteres)
- `tipo`: Enum ('aluno' ou 'professor')
- `created_at`, `updated_at`: Timestamps

### Equipamento
- `id`: Chave primária
- `nome`: Nome do equipamento
- `patrimonio`: String única com 12 dígitos numéricos
- `descricao`: Descrição opcional
- `quantidade`: Quantidade total
- `quantidade_disponivel`: Quantidade disponível para emprestar
- `status`: Enum ('disponivel' ou 'emprestado')
- `created_at`, `updated_at`: Timestamps

### Emprestimo
- `id`: Chave primária
- `user_id`: FK → Usuario (cascade delete)
- `equipamento_id`: FK → Equipamento (restrict delete)
- `data_emprestimo`: Data de saída
- `data_prevista_devolucao`: Data esperada de retorno
- `data_devolucao`: Data real de retorno (nullable)
- `created_at`, `updated_at`: Timestamps

---

## 🎨 Paleta de Cores

O sistema usa uma paleta de cores Bootstrap padronizada. As cores estão centralizadas em `resources/views/layouts/app.blade.php` e podem ser ajustadas globalmente:

| Cor | HEX | Uso |
|-----|-----|-----|
| **Primary** | `#0d6efd` | Headers, botões principais, links |
| **Info** | `#0dcaf0` | Badges de usuários (alunos), alertas informativos |
| **Success** | `#198754` | Equipamentos disponíveis, empréstimos devolvidos |
| **Warning** | `#ffc107` | Badges de professores, empréstimos pendentes |
| **Danger** | `#dc3545` | Equipamentos emprestados, empréstimos atrasados |
| **Dark** | `#212529` | Navbar, backgrounds |
| **White** | `#ffffff` | Texto em fundos escuros, backgrounds |
| **Black** | `#000000` | Texto em fundos claros |

### Como Alterar Cores Globalmente

1. Abra `resources/views/layouts/app.blade.php`
2. Localize a seção de CSS (dentro de `<style>`)
3. Procure pelas classes `.table-primary`, `.bg-primary`, `.btn-primary`, etc.
4. Substitua os valores HEX correspondentes
5. Execute `npm run build` (produção) ou `npm run dev` (desenvolvimento)

**Exemplo:**
```css
/* Antes */
.table-primary { background-color: #0d6efd; }

/* Depois (novo primary #0056b3) */
.table-primary { background-color: #0056b3; }
```

---

## 📊 Regras de Negócio

### Empréstimos
- **Alunos**: podem emprestar por **15 dias**
- **Professores**: podem emprestar por **30 dias**
- Não é possível emprestar se `quantidade_disponivel == 0`
- Ao criar empréstimo: `quantidade_disponivel` decresce e `status` muda para "emprestado"
- Ao devolver: `quantidade_disponivel` sobe e `status` volta para "disponivel" (se todas as unidades voltarem)

### Validações
- **Patrimônio**: Exatamente 12 dígitos numéricos (validação: `numeric|digits:12`)
- **Matrícula**: Máximo 4 caracteres, única por usuário
- **Quantidade**: Valores positivos (unsigned integer)

### Relatórios
- Filtros por `tipo` (aluno/professor), `status` (disponivel/emprestado)
- Detecção automática de empréstimos atrasados (data prevista < hoje, sem devolução)
- Exibição de badges de status (verde=devolvido, amarelo=pendente, vermelho=atrasado)

---

## 🔧 Comandos Úteis

### Desenvolvimento
```bash
# Inicia servidor + queue listener + pail logs + Vite dev
composer run dev

# Apenas servidor Artisan
php artisan serve

# Apenas compilação Vite (watch)
npm run dev
```

### Banco de Dados
```bash
# Aplicar migrações pendentes
php artisan migrate

# Reset completo + re-aplicar migrações + seeders
php artisan migrate:fresh --seed

# Desfazer última migração
php artisan migrate:rollback
```

### Testes
```bash
# Executar todos os testes
composer run test

# Executar testes de um arquivo específico
php artisan test tests/Feature/EquipamentoTest.php
```

### Limpeza
```bash
# Limpar cache de configuração
php artisan config:clear

# Limpar cache de views
php artisan view:clear

# Limpar todos os caches
php artisan cache:clear
```

---

## 📝 Guia Git & Deploy

### Antes de Fazer Commit

1. **Verifique arquivos modificados:**
   ```bash
   git status
   ```

2. **Não committe arquivos sensíveis:**
   - `.env` (credenciais de banco)
   - `/vendor` (dependências PHP)
   - `/node_modules` (dependências Node)
   - `/storage/logs/*` (arquivos de log)
   
   ✅ Estes já estão no `.gitignore`

3. **Gere `.env.example` se alterar variáveis:**
   ```bash
   cp .env .env.example
   # Remova valores sensíveis de .env.example
   ```

### Workflow Recomendado

```bash
# 1. Criar branch feature
git checkout -b feature/adicionar-filtros-relatorio

# 2. Fazer alterações e testar
npm run dev
php artisan serve

# 3. Adicionar arquivos modificados
git add resources/views/equipamentos/relatorio-equipamento.blade.php
git add app/Http/Controllers/EquipamentoController.php

# 4. Commit com mensagem descritiva (em português)
git commit -m "feat: adicionar filtros por status e quantidade em relatório de equipamentos"

# 5. Push para repositório remoto
git push origin feature/adicionar-filtros-relatorio

# 6. Criar Pull Request (PR) no GitHub/GitLab
#    Descrição: explique mudanças e por quê
#    Anexe screenshots se houver mudanças na UI
```

### Convenção de Mensagens de Commit

Siga o padrão **Conventional Commits** em português:

```
<tipo>(<escopo>): <descrição>

<corpo>

<rodapé>
```

**Tipos:**
- `feat`: Nova funcionalidade
- `fix`: Correção de bug
- `refactor`: Alteração estrutural (sem alterar comportamento)
- `style`: Formatação, espaçamento, cores (sem lógica)
- `docs`: Documentação
- `test`: Testes
- `chore`: Atualizações de dependências, config

**Exemplos:**
```
feat(emprestimo): adicionar detecção automática de atrasos
fix(equipamento): corrigir cálculo de quantidade_disponível
style(layout): atualizar cores da paleta (#0d6efd → #0056b3)
docs: adicionar instruções de deploy
```

---

## 🌐 Variáveis de Ambiente (`.env`)

Crie `.env` copiando `.env.example` e configure:

```env
APP_NAME="Controle de Equipamentos"
APP_ENV=local
APP_DEBUG=true
APP_KEY=base64:...  # Gerado por `php artisan key:generate`

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=controle_equipamentos
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@equipamentos.local
```

---

## 🤝 Contribuindo

1. Faça fork do repositório
2. Crie uma branch (`git checkout -b feature/xyz`)
3. Commit suas mudanças com mensagens claras
4. Push para a branch (`git push origin feature/xyz`)
5. Abra um Pull Request

**Checklist antes de PR:**
- [ ] Código testado localmente
- [ ] Mensagens de commit claras e descritivas
- [ ] Sem arquivos sensíveis (`.env`, `vendor/`, etc.)
- [ ] Migração criada (se houver mudanças de BD)
- [ ] Views atualizadas (se UI foi alterada)
- [ ] Seeder atualizado (se novas entidades foram adicionadas)

---

## 📞 Suporte & Dúvidas

- Verifique a documentação em `resources/views/` para entender o layout das views
- Consulte `app/Models/` para relações Eloquent
- Revise `routes/web.php` para entender as rotas disponíveis

---

## 📄 Licença

Este projeto é licenciado sob a MIT License.

---

**Desenvolvido com ❤️ em Laravel**
