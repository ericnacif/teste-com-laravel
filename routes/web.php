use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Tarefa;

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
        'prioridade' => 'required|in:baixa,media,alta',
        'prazo' => 'nullable|date',
    ]);

    Tarefa::create([
        'titulo' => $request->titulo,
        'descricao' => $request->descricao,
        'prioridade' => $request->prioridade,
        'prazo' => $request->prazo,
        'concluida' => false,
    ]);

    return redirect('/')->with('success', 'Tarefa adicionada!');
});

Route::get('/tarefas/{id}/toggle', function ($id) {
    $tarefa = Tarefa::findOrFail($id);
    $tarefa->concluida = !$tarefa->concluida;
    $tarefa->save();
    return redirect('/');
});

Route::get('/tarefas/{id}/excluir', function ($id) {
    Tarefa::findOrFail($id)->delete();
    return redirect('/')->with('success', 'Tarefa excluída!');
});
