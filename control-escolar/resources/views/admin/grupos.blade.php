@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white border border-blue-100 rounded-xl shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h1 class="text-4xl font-bold text-blue-900">Grupos</h1>
                <p class="text-gray-600 mt-1">Lista de grupos disponibles del sistema</p>
            </div>
            <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800">Gestión de Grupos</span>
        </div>
    </div>

    @if(session('success'))
        <div id="alert-success" class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded transition-opacity duration-300">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulario para registrar nuevo grupo -->
    <div class="mt-6 bg-white border border-blue-100 rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold mb-4 text-blue-800">Registrar Nuevo Grupo</h2>
        <form action="{{ route('grupos') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="horario_id" class="block text-sm font-medium text-gray-700">Horario</label>
                    <input type="text" id="horario_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm px-3 py-2" placeholder="Buscar horario..." list="horariosList" onchange="setHorario('horario_id', 'horario_name')" required>
                    <datalist id="horariosList">
                        @foreach($horarios as $horario)
                            <option value="{{ $horario->materia->nombre }} - {{ $horario->user->name }} ({{ $horario->hora_inicio }} - {{ $horario->hora_fin }})" data-id="{{ $horario->id }}"></option>
                        @endforeach
                    </datalist>
                    <input type="hidden" name="horario_id" id="horario_id">
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
        <table class="min-w-full bg-white shadow rounded-xl border border-gray-200">
            <thead class="bg-blue-50">
                <tr>
                    <th class="py-2 px-4 text-left">ID</th>
                    <th class="py-2 px-4 text-left">Horario</th>
                    <th class="py-2 px-4 text-left">Nombre del Grupo</th>
                    <th class="py-2 px-4 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($grupos as $grupo)
                    <tr>
                        <td class="py-2 px-4">{{ $grupo->id }}</td>
                        <td class="py-2 px-4">{{ $grupo->horario->materia->nombre }} - {{ $grupo->horario->user->name }} ({{ $grupo->horario->hora_inicio }} - {{ $grupo->horario->hora_fin }})</td>
                        <td class="py-2 px-4">{{ $grupo->nombre }}</td>
                        <td class="py-2 px-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('grupos.edit', $grupo->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-800"><i class="fa-solid fa-pen-to-square"></i></a>
                                <form action="{{ route('grupos.delete', $grupo->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-800" onclick="return confirm('¿Estás seguro de que quieres borrar este grupo?')"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
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

<script>
    function setHorario(hiddenId, inputName) {
        const input = document.getElementById(inputName);
        const hidden = document.getElementById(hiddenId);
        const datalist = document.getElementById('horariosList');
        
        if (input.value) {
            const option = Array.from(datalist.options).find(opt => opt.value === input.value);
            if (option && option.dataset.id) {
                hidden.value = option.dataset.id;
            } else {
                hidden.value = '';
            }
        } else {
            hidden.value = '';
        }
    }

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