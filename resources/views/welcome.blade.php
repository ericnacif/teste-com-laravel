<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciador de Tarefas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-300 min-h-screen p-6">
    <div class="max-w-5xl mx-auto bg-white shadow-xl rounded-2xl p-8">
        <h1 class="text-3xl font-bold mb-6 text-center">Gerenciador de Tarefas</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="/tarefas" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            @csrf
            <input type="text" name="titulo" placeholder="Título" required class="border p-2 rounded w-full">
            <select name="prioridade" class="border p-2 rounded w-full">
                <option value="">Prioridade</option>
                <option value="baixa">Baixa</option>
                <option value="media">Média</option>
                <option value="alta">Alta</option>
            </select>
            <textarea name="descricao" placeholder="Descrição" class="border p-2 rounded col-span-1 md:col-span-2"></textarea>
            <input type="date" name="data_limite" class="border p-2 rounded">
            <input type="file" name="anexo" class="border p-2 rounded">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 col-span-1 md:col-span-2">Adicionar Tarefa</button>
        </form>

        <div class="mb-4">
            <a href="/?filtro=todas" class="text-blue-600 mr-3">Todas</a>
            <a href="/?filtro=pendentes" class="text-yellow-600 mr-3">Pendentes</a>
            <a href="/?filtro=concluidas" class="text-green-600">Concluídas</a>
        </div>

        <ul class="space-y-3">
            @forelse($tarefas as $tarefa)
                <li class="bg-gray-100 p-4 rounded-lg shadow flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div class="flex flex-col md:flex-row items-start md:items-center gap-3 w-full">
                        <input type="checkbox" @if($tarefa->concluida) checked @endif onclick="location.href='/tarefas/{{$tarefa->id}}/toggle'" class="h-5 w-5 text-indigo-600">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold @if($tarefa->concluida) line-through text-gray-500 @endif">{{ $tarefa->titulo }}</h3>
                            @if($tarefa->descricao)<p class="text-sm text-gray-600">{{ $tarefa->descricao }}</p>@endif
                            @if($tarefa->prioridade)<p class="text-xs text-indigo-500">Prioridade: {{ ucfirst($tarefa->prioridade) }}</p>@endif
                            @if($tarefa->data_limite)<p class="text-xs text-gray-500">Data limite: {{ \Carbon\Carbon::parse($tarefa->data_limite)->format('d/m/Y') }}</p>@endif
                            @if($tarefa->anexo)
                                <a href="{{ Storage::url($tarefa->anexo) }}" class="text-sm text-blue-500 underline" target="_blank">Ver anexo</a>
                            @endif
                        </div>
                    </div>
                    <div class="flex gap-2 mt-3 md:mt-0">
                        <a href="/tarefas/{{ $tarefa->id }}/editar" class="text-blue-600 hover:underline">Editar</a>
                        <a href="/tarefas/{{ $tarefa->id }}/excluir" class="text-red-600 hover:underline" onclick="return confirm('Deseja excluir?')">Excluir</a>
                    </div>
                </li>
            @empty
                <li class="text-center text-gray-500">Nenhuma tarefa encontrada.</li>
            @endforelse
        </ul>
    </div>
</body>
</html>
