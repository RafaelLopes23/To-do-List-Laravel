<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa as migrações: cria a tabela de tarefas.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->enum('status', ['pendente', 'concluida'])->default('pendente')->index();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverte as migrações: remove a tabela de tarefas.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
