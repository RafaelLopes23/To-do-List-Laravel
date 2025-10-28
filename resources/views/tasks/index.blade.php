@extends('layouts.todo')

@section('title', 'Tarefas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 m-0">Tarefas</h1>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">Nova tarefa</a>
</div>

<form method="get" class="row gy-2 gx-2 align-items-end mb-3">
    <div class="col-auto">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="" {{ $status === null ? 'selected' : '' }}>Todos</option>
            <option value="pendente" {{ $status === 'pendente' ? 'selected' : '' }}>Pendente</option>
            <option value="concluida" {{ $status === 'concluida' ? 'selected' : '' }}>Concluída</option>
        </select>
    </div>
    <div class="col-auto">
        <button class="btn btn-outline-secondary">Filtrar</button>
    </div>
</form>

@if($tasks->count() === 0)
    <div class="alert alert-info">Nenhuma tarefa encontrada.</div>
@else
<table class="table table-striped align-middle">
    <thead>
        <tr>
            <th>Título</th>
            <th>Status</th>
            <th>Criação</th>
            <th class="text-end">Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tasks as $task)
            <tr>
                <td>{{ $task->title }}</td>
                <td>
                    @if($task->status === 'concluida')
                        <span class="badge text-bg-success">Concluída</span>
                    @else
                        <span class="badge text-bg-warning">Pendente</span>
                    @endif
                </td>
                <td>{{ $task->created_at->format('d/m/Y H:i') }}</td>
                <td class="text-end">
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                    <a href="{{ route('tasks.confirm-delete', $task) }}" class="btn btn-sm btn-outline-danger">Excluir</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $tasks->links() }}
@endif
@endsection
