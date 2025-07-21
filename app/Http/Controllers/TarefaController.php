<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarefa;

class TarefaController extends Controller
{
    public function index()
    {
        $tarefas = Tarefa::all();
        return view('welcome', compact('tarefas'));
    }

    public function store(Request $request)
    {
        Tarefa::create(['titulo' => $request->titulo]);
        return redirect('/');
    }

    public function toggle($id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $tarefa->concluida = !$tarefa->concluida;
        $tarefa->save();
        return redirect('/');
    }

    public function edit($id)
    {
        $tarefa = Tarefa::findOrFail($id);
        return view('editar', compact('tarefa'));
    }

    public function update(Request $request, $id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $tarefa->titulo = $request->titulo;
        $tarefa->save();
        return redirect('/');
    }

    public function destroy($id)
    {
        Tarefa::destroy($id);
        return redirect('/');
    }
}
