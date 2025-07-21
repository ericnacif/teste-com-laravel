<?php

<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Tarefa;

Route::get('/', function () {
    $tarefas = Tarefa::orderBy('created_at', 'desc')->get();
    return view('tarefas', compact('tarefas'));
});

Route::post('/tarefas', function (Request $request) {
    $request->validate([
        'titulo' => 'required|max:255',
        'descricao' => 'nullable|max:1000',
        'prioridade' => 'required',
        'prazo' => 'required|date'
    ]);

    Tarefa::create([
        'titulo' => $request->titulo,
        'descricao' => $request->descricao,
        'prioridade' => $request->prioridade,
        'prazo' => $request->prazo,
        'concluida' => false
    ]);

    return response()->json(['success' => true]);
});
