<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Tarefa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <form action="/tarefas/{{ $tarefa->id }}/editar" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-lg w-full max-w-xl">
        @csrf
        <h2 class="text-2xl font-bold mb-4">Editar Tarefa</h2>

        <input type="text" name="titulo" value="{{ $tarefa->titulo }}" class="w-full mb-3 p-2 border rounded" required>
        <textarea name="descricao" class="w-full mb-3 p-2 border rounded">{{ $tarefa->descricao }}</textarea>
        <select name="prioridade" class="w-full mb-3 p-2 border rounded">
            <option value="">Prioridade</option>
            <option value="baixa" @if($tarefa->prioridade == 'baixa') selected @endif>Baixa</option>
            <option value="media" @if($tarefa->prioridade == 'media') selected @endif>Média</option>
            <option value="alta" @if($tarefa->prioridade == 'alta') selected @endif>Alta</option>
        </select>
        <input type="date" name="data_limite" value="{{ $tarefa->data_limite }}" class="w-full mb-3 p-2 border rounded">
        <input type="file" name="anexo" class="w-full mb-3 p-2 border rounded">
        @if($tarefa->anexo)
            <p class="mb-2">Anexo atual: <a href="{{ Storage::url($tarefa->anexo) }}" class="text-blue-600 underline" target="_blank">Ver</a></p>
        @endif
        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">Salvar Alterações</button>
    </form>
</body>
</html>
