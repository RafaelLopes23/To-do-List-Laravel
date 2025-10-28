@extends('layouts.todo')

@section('title', 'Lixeira')

@section('content')
<h1 class="h3 mb-3">Lixeira</h1>
@if($tasks->count() === 0)
    <div class="alert alert-info">Nenhuma tarefa na lixeira.</div>
@else
<table class="table table-striped align-middle">
    <thead>
        <tr>
            <th>Título</th>
            <th>Excluída em</th>
            <th class="text-end">Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tasks as $task)
            <tr>
                <td>{{ $task->title }}</td>
                <td>{{ optional($task->deleted_at)->format('d/m/Y H:i') }}</td>
                <td class="text-end">
                    <form method="post" action="{{ route('tasks.restore', $task->id) }}">
                        @csrf
                        <button class="btn btn-sm btn-outline-success">Restaurar</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $tasks->links() }}
@endif
@endsection
