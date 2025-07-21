<?php

public function up()
{
    Schema::create('tarefas', function (Blueprint $table) {
        $table->id();
        $table->string('titulo');
        $table->text('descricao')->nullable();
        $table->string('prioridade')->nullable();
        $table->date('data_limite')->nullable();
        $table->boolean('concluida')->default(false);
        $table->string('anexo')->nullable();
        $table->timestamps();
    });
}
