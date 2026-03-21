@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold">Calificaciones</h1>
    <p class="text-gray-600">Lista de calificaciones disponibles del sistema</p>

    @if(session('success'))
        <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulario para registrar nueva calificacion -->
    <div class="mt-6 bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-4">Registrar Nueva Calificación</h2>
        <form action="{{ route('calificaciones') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700">Usuario</label>
                    <select name="user_id" id="user_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="">Seleccionar Usuario</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="materia_id" class="block text-sm font-medium text-gray-700">Materia</label>
                    <select name="materia_id" id="materia_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="">Seleccionar Materia</option>
                        @foreach($materias as $materia)
                            <option value="{{ $materia->id }}">{{ $materia->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="calificacion" class="block text-sm font-medium text-gray-700">Calificación</label>
                    <input type="number" step="0.01" min="0" max="10" name="calificacion" id="calificacion" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Registrar Calificación</button>
            </div>
        </form>
    </div>

    <div class="mt-6 overflow-x-auto">
        <table class="min-w-full bg-white shadow rounded-lg">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 text-left">ID</th>
                    <th class="py-2 px-4 text-left">Usuario</th>
                    <th class="py-2 px-4 text-left">Materia</th>
                    <th class="py-2 px-4 text-left">Calificación</th>
                    <th class="py-2 px-4 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($calificaciones as $calificacion)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $calificacion->id }}</td>
                        <td class="py-2 px-4">{{ $calificacion->user->name }}</td>
                        <td class="py-2 px-4">{{ $calificacion->materia->nombre }}</td>
                        <td class="py-2 px-4">{{ $calificacion->calificacion }}</td>
                        <td class="py-2 px-4 flex space-x-2">
                            <a href="{{ route('calificaciones.edit', $calificacion->id) }}" class="text-blue-600 hover:text-blue-800">Editar</a>
                            <form action="{{ route('calificaciones.delete', $calificacion->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de que quieres borrar esta calificación?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Borrar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-2 px-4 text-center text-gray-500">No hay calificaciones registradas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection