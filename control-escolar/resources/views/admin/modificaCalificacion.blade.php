@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold">Editar Calificación</h1>
    <p class="text-gray-600">Modifica los datos de la calificación</p>

    @if(session('success'))
        <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mt-6 bg-white shadow rounded-lg p-6">
        <form action="{{ route('calificaciones.update', $calificacion->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700">Usuario</label>
                    <select name="user_id" id="user_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="">Seleccionar Usuario</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $calificacion->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="materia_id" class="block text-sm font-medium text-gray-700">Materia</label>
                    <select name="materia_id" id="materia_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="">Seleccionar Materia</option>
                        @foreach($materias as $materia)
                            <option value="{{ $materia->id }}" {{ $calificacion->materia_id == $materia->id ? 'selected' : '' }}>{{ $materia->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="calificacion" class="block text-sm font-medium text-gray-700">Calificación</label>
                    <input type="number" step="0.01" min="0" max="10" name="calificacion" id="calificacion" value="{{ $calificacion->calificacion }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
            </div>
            <div class="mt-4 flex space-x-4">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Actualizar Calificación</button>
                <a href="{{ route('calificaciones') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection