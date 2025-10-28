# To-Do List Laravel

Aplicação simples para gerenciar uma lista de tarefas (to-do list), construída em Laravel 12, atendendo aos requisitos do teste técnico.

## Funcionalidades

- Cadastro de tarefas com título (obrigatório, máx. 255), descrição (opcional) e status (pendente ou concluída)
- Listagem paginada (10 por página)
- Filtro por status (pendente/concluída)
- Edição de título, descrição e status
- Exclusão com soft delete (lixeira) e restauração
- Validação com FormRequest
- Rotas RESTful via `Route::resource()` com rotas extras para confirmação de exclusão, lixeira e restauração
- Views com Blade usando layout base e partial de mensagens

## Como rodar localmente

Pré-requisitos: PHP 8.2+ e Composer

```bash
composer install
cp -n .env.example .env || true
php artisan key:generate
mkdir -p database && touch database/database.sqlite
php artisan migrate
php artisan serve
```

Acesse http://127.0.0.1:8000

## Rotas principais

- GET /tasks — listagem com filtro e paginação
- GET /tasks/create — criação
- POST /tasks — salvar
- GET /tasks/{task}/edit — editar
- PUT /tasks/{task} — atualizar
- GET /tasks/{task}/confirm-delete — confirmar exclusão
- DELETE /tasks/{task} — excluir (soft delete)
- GET /tasks-trashed — lixeira
- POST /tasks/{id}/restore — restaurar

## Autenticação (bônus)

As rotas de tarefas estão protegidas por autenticação. O projeto inclui apenas login/registro e logout. Fluxos não essenciais ao escopo foram removidos (verificação de e-mail, redefinição/atualização de senha e confirmação de senha) para manter a solução simples e focada. Após autenticar, você é redirecionado para a lista de tarefas.

## Decisões de projeto (breve)

- Simplicidade primeiro: uso de SQLite para facilitar setup local (arquivo `database/database.sqlite`) e evitar dependências externas.
- Validação via FormRequest: regras centralizadas em `TaskRequest` para manter controllers enxutos.
- Soft delete: permite lixeira e restauração, evitando perda acidental de dados.
- Layout próprio para tarefas: views usam `resources/views/layouts/todo.blade.php` com Bootstrap via CDN, isolando a UI da área autenticada.
- Autenticação enxuta: somente login/registro/logout. Removidos fluxos de verificação de e-mail e de senha para reduzir atrito e complexidade.
- UX em rotas guest: ao acessar login/registro já autenticado, uma mensagem informativa é exibida e o usuário é redirecionado para `/tasks`.

## Melhorias futuras

- Internacionalização completa (strings das views de auth) e arquivos de tradução.
- Busca por texto livre (título/descrição) e filtros combinados.
- Ordenação personalizável (por status, título, data de criação/conclusão).
- Marcar como concluída diretamente na listagem (AJAX) e melhorias de UX.
- API pública (endpoints JSON) com tokens pessoais.
- Paginação configurável e testes adicionais (incluindo UI/Browser se desejado).

## Testes

Para executar os testes:

```bash
php artisan test
```

Os testes de autenticação cobrem login e registro; os de tarefas cobrem criação, filtro por status e soft delete/restauração.