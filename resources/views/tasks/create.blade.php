@extends('layouts.todo')

@section('title', 'Nova tarefa')

@section('content')
<h1 class="h3 mb-3">Nova tarefa</h1>
<form method="post" action="{{ route('tasks.store') }}" class="card card-body">
    @csrf
    <div class="mb-3">
        <label class="form-label">Título *</label>
        <input type="text" name="title" class="form-control" maxlength="255" value="{{ old('title') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Descrição</label>
        <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="pendente" {{ old('status', 'pendente') === 'pendente' ? 'selected' : '' }}>Pendente</option>
            <option value="concluida" {{ old('status') === 'concluida' ? 'selected' : '' }}>Concluída</option>
        </select>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancelar</a>
        <button class="btn btn-primary">Salvar</button>
    </div>
</form>
@endsection
