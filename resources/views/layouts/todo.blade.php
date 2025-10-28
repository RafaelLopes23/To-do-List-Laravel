<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'To-Do List')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('tasks.index') }}">To-Do</a>
        <div class="ms-auto d-flex align-items-center gap-2">
            <a class="btn btn-outline-light btn-sm" href="{{ route('tasks.index') }}">Tarefas</a>
            <a class="btn btn-outline-light btn-sm" href="{{ route('tasks.trashed') }}">Lixeira</a>
            @auth
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-warning btn-sm">Sair</button>
                </form>
            @endauth
        </div>
    </div>
</nav>
<main class="container">
    @include('partials.flash')
    @yield('content')
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
