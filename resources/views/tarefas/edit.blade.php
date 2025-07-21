<!DOCTYPE html>
<html>
<head>
    <title>Editar Tarefa</title>
</head>
<body>
    <h1>Editar Tarefa</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $erro)
                <li style="color:red;">{{ $erro }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('tarefas.update', $tarefa) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="titulo" value="{{ $tarefa->titulo }}" required>
        <br>
        <label>
            <input type="checkbox" name="concluida" value="1" {{ $tarefa->concluida ? 'checked' : '' }}>
            Concluída
        </label>
        <br>
        <button type="submit">Salvar Alterações</button>
    </form>

    <a href="{{ route('tarefas.index') }}">← Voltar</a>
</body>
</html>
