<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App de Tarefas</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="dark-theme">
    <main>
        <section class="container">
            <h1>Minhas Tarefas</h1>

            <form id="form-tarefa">
                <input type="text" name="titulo" placeholder="Título" required>
                <textarea name="descricao" placeholder="Descrição (opcional)"></textarea>
                <select name="prioridade" required>
                    <option value="Alta">Alta</option>
                    <option value="Média">Média</option>
                    <option value="Baixa">Baixa</option>
                </select>
                <input type="date" name="prazo" required>
                <button type="submit">Adicionar</button>
            </form>

            <ul id="lista-tarefas">
                @foreach($tarefas as $tarefa)
                    <li class="fade-in">
                        <strong>{{ $tarefa->titulo }}</strong><br>
                        {{ $tarefa->descricao }}<br>
                        Prioridade: {{ $tarefa->prioridade }}<br>
                        Prazo: {{ $tarefa->prazo }}
                    </li>
                @endforeach
            </ul>
        </section>
    </main>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
