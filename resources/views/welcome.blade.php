<!DOCTYPE html>
<html lang="pt-BR" data-theme="light">
<head>
    <meta charset="UTF-8">
    <title>Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="/css/app.css">
    <script>
        function toggleTema() {
            const html = document.documentElement;
            html.dataset.theme = html.dataset.theme === 'dark' ? 'light' : 'dark';
        }
    </script>
</head>
<body>
    <div class="container">
        <header>
            <h1>Minhas Tarefas</h1>
            <button onclick="toggleTema()">🌓 Alternar Tema</button>
        </header>

        <form method="POST" action="/tarefas" class="formulario">
            @csrf
            <input type="text" name="titulo" placeholder="Título da tarefa" required>
            <textarea name="descricao" placeholder="Descrição (opcional)"></textarea>
            <select name="prioridade">
                <option value="">Prioridade</option>
                <option value="Baixa">Baixa</option>
                <option value="Média">Média</option>
                <option value="Alta">Alta</option>
            </select>
            <input type="date" name="prazo">
            <button type="submit">Adicionar</button>
        </form>

        <div class="filtros">
            <a href="/?filtro=todas">Todas</a>
            <a href="/?filtro=pendentes">Pendentes</a>
            <a href="/?filtro=concluidas">Concluídas</a>
        </div>

        <ul class="lista">
            @forelse($tarefas as $tarefa)
                <li class="{{ $tarefa->concluida ? 'concluida' : '' }}">
                    <div>
                        <input type="checkbox" onclick="location.href='/tarefas/{{$tarefa->id}}/toggle'" {{ $tarefa->concluida ? 'checked' : '' }}>
                        <strong>{{ $tarefa->titulo }}</strong>
                        @if($tarefa->descricao)
                            <p>{{ $tarefa->descricao }}</p>
                        @endif
                        <small>Prioridade: {{ $tarefa->prioridade ?? 'N/A' }}</small>
                        @if($tarefa->prazo)
                            <small class="{{ now()->gt($tarefa->prazo) && !$tarefa->concluida ? 'atrasada' : '' }}">
                                Prazo: {{ \Carbon\Carbon::parse($tarefa->prazo)->format('d/m/Y') }}
                            </small>
                        @endif
                    </div>
                    <a href="/tarefas/{{$tarefa->id}}/excluir">🗑</a>
                </li>
            @empty
                <p>Nenhuma tarefa encontrada.</p>
            @endforelse
        </ul>
    </div>
</body>
</html>
