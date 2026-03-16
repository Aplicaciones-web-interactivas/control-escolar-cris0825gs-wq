@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold">Materias</h1>
    <p class="text-gray-600">Lista de materias disponibles del sistema</p>

    @if(session('success'))
        <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulario para registrar nueva materia -->
    <div class="mt-6 bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-4">Registrar Nueva Materia</h2>
        <form action="{{ route('materias') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
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
        <table class="min-w-full bg-white shadow rounded-lg">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 text-left">ID</th>
                    <th class="py-2 px-4 text-left">Nombre</th>
                    <th class="py-2 px-4 text-left">Clave</th>
                    <th class="py-2 px-4 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($materias as $materia)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $materia->id }}</td>
                        <td class="py-2 px-4">{{ $materia->nombre }}</td>
                        <td class="py-2 px-4">{{ $materia->clave }}</td>
                        <td class="py-2 px-4"><a href="#" class="text-indigo-600 hover:text-indigo-800">Ver</a></td>
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
