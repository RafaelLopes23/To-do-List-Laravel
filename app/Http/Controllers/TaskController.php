<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{
    /**
     * Exibe a listagem de tarefas com filtro e paginação.
     */
    public function index()
    {
        $status = request('status');

        $query = Task::query()->orderByDesc('created_at');
        if (in_array($status, ['pendente', 'concluida'])) {
            $query->where('status', $status);
        } else {
            $status = null; // normalize invalid values
        }

        $tasks = $query->paginate(10)->withQueryString();

        return view('tasks.index', compact('tasks', 'status'));
    }

    /**
     * Exibe o formulário de criação de uma nova tarefa.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Salva uma nova tarefa no banco de dados.
     */
    public function store(TaskRequest $request)
    {
        $data = $request->validated();
        Task::create($data);

        return redirect()->route('tasks.index')->with('success', 'Tarefa criada com sucesso.');
    }

    /**
     * Exibe uma tarefa específica (não utilizado; redireciona para edição).
     */
    public function show(Task $task)
    {
        // Não utilizado; redireciona para a tela de edição
        return redirect()->route('tasks.edit', $task);
    }

    /**
     * Exibe o formulário de edição da tarefa informada.
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Atualiza a tarefa informada no banco de dados.
     */
    public function update(TaskRequest $request, Task $task)
    {
        $data = $request->validated();
        $task->update($data);

        return redirect()->route('tasks.index')->with('success', 'Tarefa atualizada com sucesso.');
    }

    /**
     * Remove (soft delete) a tarefa informada.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tarefa excluída com sucesso.');
    }

    /**
     * Exibe a página de confirmação antes de excluir a tarefa.
     */
    public function confirmDelete(Task $task)
    {
        return view('tasks.confirm-delete', compact('task'));
    }

    /**
     * Lista tarefas enviadas para a lixeira (soft-deleted).
     */
    public function trashed()
    {
        $tasks = Task::onlyTrashed()->orderByDesc('deleted_at')->paginate(10);
        return view('tasks.trashed', compact('tasks'));
    }

    /**
     * Restaura uma tarefa removida logicamente (soft delete).
     */
    public function restore($id)
    {
        $task = Task::onlyTrashed()->findOrFail($id);
        $task->restore();
        return redirect()->route('tasks.index')->with('success', 'Tarefa restaurada com sucesso.');
    }
}
