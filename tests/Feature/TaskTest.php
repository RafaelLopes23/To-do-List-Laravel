<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Autentica um usuário para acessar as rotas protegidas
        $this->actingAs(User::factory()->create());
    }

    public function test_can_create_task(): void
    {
        $response = $this->post(route('tasks.store'), [
            'title' => 'Minha tarefa',
            'description' => 'Descrição opcional',
            'status' => 'pendente',
        ]);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'title' => 'Minha tarefa',
            'status' => 'pendente',
            'deleted_at' => null,
        ]);

        $response = $this->get(route('tasks.index'));
        $response->assertSee('Minha tarefa');
    }

    public function test_can_filter_by_status(): void
    {
    Task::factory()->create(['title' => 'TarefaP', 'status' => 'pendente']);
    Task::factory()->create(['title' => 'TarefaC', 'status' => 'concluida']);

        $resp1 = $this->get(route('tasks.index', ['status' => 'pendente']));
        $resp1->assertOk();
        $resp1->assertSee('TarefaP');
        $resp1->assertDontSee('TarefaC');

        $resp2 = $this->get(route('tasks.index', ['status' => 'concluida']));
        $resp2->assertOk();
        $resp2->assertSee('TarefaC');
        $resp2->assertDontSee('TarefaP');
    }

    public function test_soft_delete_and_restore(): void
    {
        $task = Task::factory()->create(['status' => 'pendente']);

        $this->delete(route('tasks.destroy', $task))->assertRedirect(route('tasks.index'));
        $this->assertSoftDeleted('tasks', ['id' => $task->id]);

        $this->post(route('tasks.restore', $task->id))->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'deleted_at' => null]);
    }
}
