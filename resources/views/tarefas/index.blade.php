<!DOCTYPE html>
<html>
<head>
    <title>Lista de Tarefas</title>
</head>
<body>
    <h1>Minhas Tarefas</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <a href="{{ route('tarefas.create') }}">+ Nova Tarefa</a>

    <ul>
        @foreach ($tarefas as $tarefa)
            <li>
                <strong>{{ $tarefa->titulo }}</strong>
                @if($tarefa->concluida)
                    <span style="color:green;">(Concluída)</span>
                @endif

                <a href="{{ route('tarefas.edit', $tarefa) }}">Editar</a>

                <form action="{{ route('tarefas.destroy', $tarefa) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Excluir</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>
