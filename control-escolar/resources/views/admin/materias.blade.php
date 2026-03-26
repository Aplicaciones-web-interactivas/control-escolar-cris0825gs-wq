@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-lg p-6 border border-blue-100 mb-6">
        <h1 class="text-4xl font-bold text-blue-900">Materias</h1>
        <p class="mt-1 text-gray-600">Listado de materias disponibles en el sistema</p>
    </div>

    @if(session('success'))
        <div id="alert-success" class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded transition-opacity duration-300">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulario para filtrar materias -->
    <div class="mt-6 bg-gray-200 shadow rounded-lg p-6">
        <div class="flex flex-col md:flex-row md:items-center gap-4">
            <span class="text-lg font-semibold text-gray-700">Filtrar:</span>
            <form action="{{ route('materias') }}" method="GET" class="flex flex-col md:flex-row gap-4 flex-1 items-end">
                <div class="bg-white rounded-md p-3 min-w-0 flex-1 md:max-w-xs">
                    <label for="filter_nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Materia</label>
                    <input type="text" name="filter_nombre" id="filter_nombre" class="block w-full border-gray-300 rounded-md shadow-sm px-3 py-2" placeholder="Buscar materia..." value="{{ $nombreFiltro }}" onchange="this.form.submit()">
                </div>
                <div class="flex items-center md:ml-auto">
                    <a href="{{ route('materias') }}" class="text-indigo-600 hover:text-indigo-800 underline flex items-center gap-1">
                        <i class="fa-solid fa-eraser"></i>Limpiar filtros
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Formulario para registrar nueva materia -->
    <div class="mt-6 bg-white shadow rounded-xl border border-blue-100 p-6">
        <h2 class="text-lg font-semibold mb-4 text-blue-800">Registrar Nueva Materia</h2>
        <form action="{{ route('materias') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre de la materia</label>
                    <input type="text" name="nombre" id="nombre" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div>
                    <label for="clave" class="block text-sm font-medium text-gray-700">Clave</label>
                    <input type="text" name="clave" id="clave" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Registrar Materia</button>
            </div>
        </form>
    </div>

    <div class="mt-6 overflow-x-auto">
        <table class="min-w-full bg-white shadow rounded-xl border border-gray-200">
            <thead class="bg-blue-50">
                <tr>
                    <th class="py-2 px-4 text-left">ID</th>
                    <th class="py-2 px-4 text-left">Nombre de la Materia</th>
                    <th class="py-2 px-4 text-left">Clave</th>
                    <th class="py-2 px-4 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($materias as $materia)
                    <tr>
                        <td class="py-2 px-4">{{ $materia->id }}</td>
                        <td class="py-2 px-4">{{ $materia->nombre }}</td>
                        <td class="py-2 px-4">{{ $materia->clave }}</td>
                                <td class="py-2 px-4">
                            <div class="flex items-center gap-2 text-sm">
                                <a href="{{ route('materias.edit', $materia->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-800"><i class="fa-solid fa-pen-to-square"></i></a>
                                <form action="{{ route('materias.delete', $materia->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de que quieres borrar esta materia?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-800"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-2 px-4 text-center text-gray-500">No hay materias registradas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

<script>
    // Ocultar mensajes de alerta automáticamente después de 4 segundos
    document.addEventListener('DOMContentLoaded', function() {
        const alertSuccess = document.getElementById('alert-success');
        if (alertSuccess) {
            setTimeout(function() {
                alertSuccess.style.opacity = '0';
                alertSuccess.style.transition = 'opacity 0.3s ease-out';
                setTimeout(function() {
                    alertSuccess.style.display = 'none';
                }, 300);
            }, 4000);
        }
    });
</script>