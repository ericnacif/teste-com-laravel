<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Tarefa;
use Illuminate\Support\Facades\Storage;

Route::get('/', function (Request $request) {
    $filtro = $request->query('filtro', 'todas');
    $tarefas = match ($filtro) {
        'concluidas' => Tarefa::where('concluida', true)->get(),
        'pendentes' => Tarefa::where('concluida', false)->get(),
        default => Tarefa::all(),
    };
    return view('welcome', compact('tarefas', 'filtro'));
});

Route::post('/tarefas', function (Request $request) {
    $request->validate([
        'titulo' => 'required|string|max:255',
        'descricao' => 'nullable|string',
        'prioridade' => 'nullable|in:baixa,media,alta',
        'data_limite' => 'nullable|date',
        'anexo' => 'nullable|file|max:2048',
    ]);

    $anexoPath = $request->hasFile('anexo') ? $request->file('anexo')->store('anexos') : null;

    Tarefa::create([
        'titulo' => $request->titulo,
        'descricao' => $request->descricao,
        'prioridade' => $request->prioridade,
        'data_limite' => $request->data_limite,
        'anexo' => $anexoPath,
        'concluida' => false,
    ]);

    return redirect('/')->with('success', 'Tarefa adicionada com sucesso!');
});

Route::get('/tarefas/{id}/editar', function ($id) {
    $tarefa = Tarefa::findOrFail($id);
    return view('editar', compact('tarefa'));
});

Route::post('/tarefas/{id}/editar', function (Request $request, $id) {
    $request->validate([
        'titulo' => 'required|string|max:255',
        'descricao' => 'nullable|string',
        'prioridade' => 'nullable|in:baixa,media,alta',
        'data_limite' => 'nullable|date',
        'anexo' => 'nullable|file|max:2048',
    ]);

    $tarefa = Tarefa::findOrFail($id);

    if ($request->hasFile('anexo')) {
        if ($tarefa->anexo) {
            Storage::delete($tarefa->anexo);
        }
        $tarefa->anexo = $request->file('anexo')->store('anexos');
    }

    $tarefa->update($request->except('anexo'));

    return redirect('/')->with('success', 'Tarefa atualizada com sucesso!');
});

Route::get('/tarefas/{id}/toggle', function ($id) {
    $tarefa = Tarefa::findOrFail($id);
    $tarefa->concluida = !$tarefa->concluida;
    $tarefa->save();
    return redirect('/');
});

Route::get('/tarefas/{id}/excluir', function ($id) {
    $tarefa = Tarefa::findOrFail($id);
    if ($tarefa->anexo) {
        Storage::delete($tarefa->anexo);
    }
    $tarefa->delete();
    return redirect('/')->with('success', 'Tarefa excluída com sucesso!');
});
