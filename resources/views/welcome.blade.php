<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Tarefas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col items-center justify-start p-6">

    <div class="w-full max-w-4xl bg-white shadow-lg rounded-xl p-6 mt-6">
        <h1 class="text-3xl font-bold text-center text-indigo-600 mb-4">Gerenciador de Tarefas</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filtros -->
        <div class="flex flex-wrap gap-2 mb-4 justify-center">
            <a href="/?filtro=todas" class="px-3 py-1 rounded-full {{ request('filtro') === 'todas' ? 'bg-indigo-600 text-white' : 'bg-gray-200' }}">Todas</a>
            <a href="/?filtro=pendentes" class="px-3 py-1 rounded-full {{ request('filtro') === 'pendentes' ? 'bg-yellow-500 text-white' : 'bg-gray-200' }}">Pendentes</a>
            <a href="/?filtro=concluidas" class="px-3 py-1 rounded-full {{ request('filtro') === 'concluidas' ? 'bg-green-600 text-white' : 'bg-gray-200' }}">Concluídas</a>
        </div>

        <!-- Formulário -->
        <form action="/tarefas" method="POST" class="space-y-4 mb-6">
            @csrf
            <input name="titulo" placeholder="Título da tarefa" class="w-full border p-2 rounded" required>
            <textarea name="descricao" placeholder="Descrição" class="w-full border p-2 rounded"></textarea>
            <div class="flex flex-col md:flex-row gap-3">
                <select name="prioridade" class="w-full md:w-1/3 border p-2 rounded" required>
                    <option value="baixa">Baixa</option>
                    <option value="media">Média</option>
                    <option value="alta">Alta</option>
                </select>
                <input type="date" name="prazo" class="w-full md:w-1/3 border p-2 rounded">
                <button type="submit" class="w-full md:w-1/3 bg-indigo-600 text-white p-2 rounded hover:bg-indigo-700">Adicionar</button>
            </div>
        </form>

        <!-- Lista -->
        <ul class="space-y-3">
            @forelse($tarefas as $tarefa)
                <li class="flex justify-between items-center bg-gray-100 p-4 rounded-lg shadow">
                    <div class="flex flex-col md:flex-row md:items-center gap-2 w-full">
                        <div class="flex items-center gap-2">
                            <input type="checkbox" onclick="location.href='/tarefas/{{$tarefa->id}}/toggle'" @if($tarefa->concluida) checked @endif>
                            <span class="@if($tarefa->concluida) line-through text-gray-500 @endif font-medium">{{ $tarefa->titulo }}</span>
                        </div>
                        <div class="text-sm text-gray-600">{{ $tarefa->descricao }}</div>
                        <div class="text-sm font-semibold text-{{ $tarefa->prioridade === 'alta' ? 'red' : ($tarefa->prioridade === 'media' ? 'yellow' : 'green') }}-600 capitalize">
                            Prioridade: {{ $tarefa->prioridade }}
                        </div>
                        @if($tarefa->prazo)
                            <div class="text-sm text-blue-600">Prazo: {{ \Carbon\Carbon::parse($tarefa->prazo)->format('d/m/Y') }}</div>
                        @endif
                    </div>
                    <a href="/tarefas/{{ $tarefa->id }}/excluir" class="text-red-600 hover:text-red-800">Excluir</a>
                </li>
            @empty
                <li class="text-gray-500 text-center">Nenhuma tarefa encontrada.</li>
            @endforelse
        </ul>
    </div>
</body>
</html>
