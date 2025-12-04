# Copilot Instructions - Sistema de Controle de Equipamentos

## Visão Geral da Arquitetura

Este é um aplicativo Laravel 12 para gerenciar empréstimo de equipamentos. Estrutura em três entidades principais:
- **Equipamentos**: Bens a serem emprestados (nome, patrimônio, status: disponível/emprestado)
- **Usuários**: Alunos e professores que pegam emprestado (matricula, tipo: aluno/professor)
- **Empréstimos**: Relaciona usuários com equipamentos, rastreando datas (empréstimo, prevista devolução, devolucao real)

### Fluxo de Dados Principal
```
Usuário → Empréstimo ← Equipamento (many-to-many através de Empréstimo)
```
- Cada Empréstimo pertence a um Usuário (`user_id` com cascade delete)
- Cada Empréstimo pertence a um Equipamento (`equipamento_id` com restrict delete)
- Status do Equipamento muda para "emprestado" quando há empréstimo ativo

## Stack Tecnológico

- **Framework**: Laravel 12 (PHP 8.2+)
- **Banco de Dados**: Migrações em `database/migrations/`
- **Frontend**: Blade templates com Tailwind CSS via Vite
- **Build**: Vite com tailwindcss plugin

## Padrões de Código

### Controllers (app/Http/Controllers/)
- RESTful: `index`, `create`, `store`, `edit`, `update`, `destroy`
- Método adicional `relatorio()` com filtros (ex: `equipamentos.relatorio` filtra por status)
- Validação inline em `store()` e `update()` usando `$request->validate()`
- Redirecionamentos com `with('success', 'mensagem')` para feedback ao usuário

Exemplo padrão em EquipamentoController:
```php
public function store(Request $request) {
    $request->validate([...]);
    Model::create($request->only([...]));
    return redirect()->route('resource.index')->with('success', 'Mensagem');
}
```

### Models (app/Models/)
- Herdam `Model` (Eloquent)
- `$fillable` lista campos atribuíveis
- Relacionamentos: `hasMany()`, `belongsTo()`
- Exemplo: Equipamento::class relaciona com Emprestimo::class

### Rotas (routes/web.php)
- Padrão: `Route::resource('usuarios', UsuarioController::class)` para CRUD
- Rotas customizadas com `.except()` para lidar com index separadamente
- Nomes bem definidos: `usuarios.inicio`, `equipamentos.relatorio`

## Workflows Críticos

### Setup Inicial
```powershell
composer run-script setup   # Instala dependências, gera .env, roda migrações, instala npm
```

### Desenvolvimento
```powershell
composer run dev   # Inicia servidor artisan, queue listener, pail logs, Vite dev server
```

### Testes
```powershell
composer run test   # Limpa config cache e executa PHPUnit
```

### Executar Migrações
```powershell
php artisan migrate         # Aplica migrações pendentes
php artisan migrate:fresh   # Reseta e re-aplica todas (dev only)
```

## Convenções Específicas

1. **Nomes de Atributos em Models**: Use snake_case em migrações (`data_emprestimo`, não `dataEmprestimo`)
2. **Foreign Keys**: Seguem padrão Laravel: `{model}_id` (ex: `user_id`, `equipamento_id`)
3. **Status de Equipamento**: Enum com valores exatos `'disponivel'` e `'emprestado'`
4. **Matricula de Usuário**: String max 4 caracteres, únicas por usuário
5. **Datas em Empréstimos**: `data_devolucao` é nullable (null = não devolvido ainda)

## Pontos de Integração

- **Relatórios**: Controllers têm métodos `relatorio()` que filtram com `::when()` baseado em query strings
- **Views**: Armazenadas em `resources/views/{modelo}/` (seguindo estrutura Blade)
- **Assets**: CSS/JS compilados via Vite em `resources/{css,js}/app.{css,js}`
- **PDF Generation**: `barryvdh/laravel-dompdf` disponível (padrão para relatórios)

## Pontos Comuns de Erro

- **Modelo "Usuario" vs "User"**: Projeto usa tabela "usuarios" mas Model herda de User Laravel; Emprestimos referencia `user_id` (não usuário_id)
- **Validação de Patrimônio**: É única (`'patrimonio' => 'required|string|max:50'`) - verificar duplicatas em updates
- **Cascade vs Restrict**: Usuários podem ser deletados se `Emprestimo::cascade`, mas Equipamentos não podem ser deletados se referenciados
