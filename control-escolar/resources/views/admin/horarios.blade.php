@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white border border-blue-100 rounded-xl shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h1 class="text-4xl font-bold text-blue-900">Horarios</h1>
                <p class="text-gray-600 mt-1">Lista de horarios disponibles del sistema</p>
            </div>
            <div class="space-x-2">
                <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800">Vista Actual</span>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div id="alert-success" class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded transition-opacity duration-300">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulario para filtrar horarios -->
    <div class="mt-6 bg-white border border-blue-100 rounded-xl shadow-sm p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <span class="text-lg font-semibold text-blue-900">Filtrar Horarios</span>
            <form action="{{ route('horarios') }}" method="GET" id="filterForm" class="flex flex-col md:flex-row gap-4 flex-1 md:justify-center">
                <div class="bg-white rounded-md p-3 min-w-0 flex-1 md:max-w-xs">
                    <label for="filter_user" class="block text-sm font-medium text-gray-700 mb-1">Usuario</label>
                    <input type="text" name="filter_user" id="filter_user" class="block w-full border-gray-300 rounded-md shadow-sm px-3 py-2" placeholder="Buscar usuario..." list="usersFilterList" onchange="setAndSubmitForm('filter_user_id', 'filter_user')" value="{{ $usuarioFiltro ?? '' }}">
                    <datalist id="usersFilterList">
                        @foreach($users as $user)
                            <option value="{{ $user->name }}" data-id="{{ $user->id }}"></option>
                        @endforeach
                    </datalist>
                    <input type="hidden" name="filter_user_id" id="filter_user_id_hidden" value="{{ $userSeleccionado ?? '' }}">
                </div>
                <div class="bg-white rounded-md p-3 min-w-0 flex-1 md:max-w-xs">
                    <label for="filter_materia" class="block text-sm font-medium text-gray-700 mb-1">Materia</label>
                    <input type="text" name="filter_materia" id="filter_materia" class="block w-full border-gray-300 rounded-md shadow-sm px-3 py-2" placeholder="Buscar materia..." list="materiasFilterList" onchange="setAndSubmitForm('filter_materia_id', 'filter_materia')" value="{{ $materiaFiltro ?? '' }}">
                    <datalist id="materiasFilterList">
                        @foreach($materias as $materia)
                            <option value="{{ $materia->nombre }}" data-id="{{ $materia->id }}"></option>
                        @endforeach
                    </datalist>
                    <input type="hidden" name="filter_materia_id" id="filter_materia_id_hidden" value="{{ $materiaSeleccionada ?? '' }}">
                </div>
                <div class="flex items-end">
                    <a href="{{ route('horarios') }}" class="text-indigo-600 hover:text-indigo-800 underline flex items-center gap-1">
                        <i class="fa-solid fa-eraser"></i>Limpiar filtros
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Formulario para registrar nuevo horario -->
    <div class="mt-6 bg-white border border-blue-100 rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold mb-4 text-blue-800">Registrar Nuevo Horario</h2>
        <form action="{{ route('horarios') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700">Usuario</label>
                    <input type="text" id="user_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm px-3 py-2" placeholder="Buscar usuario..." list="usersList" onchange="setUser('user_id', 'user_name')" required>
                    <datalist id="usersList">
                        @foreach($users as $user)
                            <option value="{{ $user->name }}" data-id="{{ $user->id }}"></option>
                        @endforeach
                    </datalist>
                    <input type="hidden" name="user_id" id="user_id">
                </div>
                <div>
                    <label for="materia_id" class="block text-sm font-medium text-gray-700">Materia</label>
                    <input type="text" id="materia_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm px-3 py-2" placeholder="Buscar materia..." list="materiasList" onchange="setMateria('materia_id', 'materia_name')" required>
                    <datalist id="materiasList">
                        @foreach($materias as $materia)
                            <option value="{{ $materia->nombre }}" data-id="{{ $materia->id }}"></option>
                        @endforeach
                    </datalist>
                    <input type="hidden" name="materia_id" id="materia_id">
                </div>
                <div>
                    <label for="hora_inicio" class="block text-sm font-medium text-gray-700">Hora Inicio</label>
                    <input type="time" name="hora_inicio" id="hora_inicio" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div>
                    <label for="hora_fin" class="block text-sm font-medium text-gray-700">Hora Fin</label>
                    <input type="time" name="hora_fin" id="hora_fin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Registrar Horario</button>
            </div>
        </form>
    </div>

    <div class="mt-6 overflow-x-auto">
        <table class="min-w-full bg-white shadow rounded-xl border border-gray-200">
            <thead class="bg-blue-50">
                <tr>
                    <th class="py-2 px-4 text-left">ID</th>
                    <th class="py-2 px-4 text-left">Usuario</th>
                    <th class="py-2 px-4 text-left">Materia</th>
                    <th class="py-2 px-4 text-left">Hora Inicio</th>
                    <th class="py-2 px-4 text-left">Hora Fin</th>
                    <th class="py-2 px-4 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($horarios as $horario)
                    <tr>
                        <td class="py-2 px-4">{{ $horario->id }}</td>
                        <td class="py-2 px-4">{{ $horario->user->name }}</td>
                        <td class="py-2 px-4">{{ $horario->materia->nombre }}</td>
                        <td class="py-2 px-4">{{ $horario->hora_inicio }}</td>
                        <td class="py-2 px-4">{{ $horario->hora_fin }}</td>
                        <td class="py-2 px-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('horarios.edit', $horario->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-800"><i class="fa-solid fa-pen-to-square"></i></a>
                                <form action="{{ route('horarios.delete', $horario->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-800" onclick="return confirm('¿Estás seguro de que quieres borrar este horario?')"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-2 px-4 text-center text-gray-500">No hay horarios registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

<script>
    function setAndSubmitForm(hiddenId, inputName) {
        const input = document.querySelector(`input[name="${inputName}"]`);
        const hidden = document.getElementById(hiddenId + '_hidden');
        const datalistId = input.getAttribute('list');
        const datalist = document.getElementById(datalistId);

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

        if (input.value) {
            document.getElementById('filterForm').submit();
        }
    }

    function setUser(hiddenId, inputName) {
        const input = document.getElementById(inputName);
        const hidden = document.getElementById(hiddenId);
        const datalist = document.getElementById('usersList');
        
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

    function setMateria(hiddenId, inputName) {
        const input = document.getElementById(inputName);
        const hidden = document.getElementById(hiddenId);
        const datalist = document.getElementById('materiasList');
        
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