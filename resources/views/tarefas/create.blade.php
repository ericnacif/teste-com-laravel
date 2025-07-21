<!DOCTYPE html>
<html>
<head>
    <title>Nova Tarefa</title>
</head>
<body>
    <h1>Criar Tarefa</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $erro)
                <li style="color:red;">{{ $erro }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('tarefas.store') }}" method="POST">
        @csrf
        <input type="text" name="titulo" placeholder="Título da tarefa" required>
        <br>
        <label>
            <input type="checkbox" name="concluida" value="1">
            Concluída
        </label>
        <br>
        <button type="submit">Salvar</button>
    </form>

    <a href="{{ route('tarefas.index') }}">← Voltar</a>
</body>
</html>
