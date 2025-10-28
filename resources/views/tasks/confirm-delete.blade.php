@extends('layouts.todo')

@section('title', 'Excluir tarefa')

@section('content')
<h1 class="h3 mb-3 text-danger">Excluir tarefa</h1>
<div class="card">
    <div class="card-body">
        <p>Tem certeza que deseja excluir esta tarefa?</p>
        <ul>
            <li><strong>Título:</strong> {{ $task->title }}</li>
            <li><strong>Status:</strong> {{ $task->status === 'concluida' ? 'Concluída' : 'Pendente' }}</li>
            <li><strong>Criada em:</strong> {{ $task->created_at->format('d/m/Y H:i') }}</li>
        </ul>
        <form method="post" action="{{ route('tasks.destroy', $task) }}" class="d-flex gap-2">
            @csrf
            @method('DELETE')
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancelar</a>
            <button class="btn btn-danger">Confirmar exclusão</button>
        </form>
    </div>
</div>
@endsection
