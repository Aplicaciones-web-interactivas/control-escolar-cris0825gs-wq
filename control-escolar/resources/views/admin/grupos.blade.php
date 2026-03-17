@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold">Grupos</h1>
    <p class="text-gray-600">Lista de grupos disponibles del sistema</p>

    @if(session('success'))
        <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulario para registrar nuevo grupo -->
    <div class="mt-6 bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-4">Registrar Nuevo Grupo</h2>
        <form action="{{ route('grupos') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="horario_id" class="block text-sm font-medium text-gray-700">Horario</label>
                    <select name="horario_id" id="horario_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="">Seleccionar Horario</option>
                        @foreach($horarios as $horario)
                            <option value="{{ $horario->id }}">{{ $horario->materia->nombre }} - {{ $horario->user->name }} ({{ $horario->hora_inicio }} - {{ $horario->hora_fin }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del Grupo</label>
                    <input type="text" name="nombre" id="nombre" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Registrar Grupo</button>
            </div>
        </form>
    </div>

    <div class="mt-6 overflow-x-auto">
        <table class="min-w-full bg-white shadow rounded-lg">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 text-left">ID</th>
                    <th class="py-2 px-4 text-left">Horario</th>
                    <th class="py-2 px-4 text-left">Nombre del Grupo</th>
                    <th class="py-2 px-4 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($grupos as $grupo)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $grupo->id }}</td>
                        <td class="py-2 px-4">{{ $grupo->horario->materia->nombre }} - {{ $grupo->horario->user->name }} ({{ $grupo->horario->hora_inicio }} - {{ $grupo->horario->hora_fin }})</td>
                        <td class="py-2 px-4">{{ $grupo->nombre }}</td>
                        <td class="py-2 px-4 flex space-x-2">
                            <a href="{{ route('grupos.edit', $grupo->id) }}" class="text-blue-600 hover:text-blue-800">Editar</a>
                            <form action="{{ route('grupos.delete', $grupo->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de que quieres borrar este grupo?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Borrar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-2 px-4 text-center text-gray-500">No hay grupos registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection