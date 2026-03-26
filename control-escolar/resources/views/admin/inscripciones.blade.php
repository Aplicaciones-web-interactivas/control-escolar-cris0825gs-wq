@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white border border-blue-100 rounded-xl shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h1 class="text-4xl font-bold text-blue-900">Inscripciones</h1>
                <p class="text-gray-600 mt-1">Puedes filtrar y gestionar las inscripciones desde aquí.</p>
            </div>
            <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800">Administración</span>
        </div>
    </div>

    @if(session('success'))
        <div id="alert-success" class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded transition-opacity duration-300">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulario para filtrar inscripciones -->
    <div class="mt-6 bg-white border border-blue-100 rounded-xl shadow-sm p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <span class="text-lg font-semibold text-blue-900">Filtrar Inscripciones</span>
            <form action="{{ route('inscripciones') }}" method="GET" id="filterForm" class="flex flex-col md:flex-row gap-4 flex-1 md:justify-center">
                <div class="bg-white rounded-md p-3 min-w-0 flex-1 md:max-w-xs">
                    <label for="filter_grupo_id" class="block text-sm font-medium text-gray-700 mb-1">Grupo</label>
                    <input type="text" name="filter_grupo" id="filter_grupo_name" class="block w-full border-gray-300 rounded-md shadow-sm px-3 py-2" placeholder="Buscar grupo..." list="gruposFilterList" onchange="setAndSubmitForm('filter_grupo_id', 'filter_grupo')" value="{{ $grupoNombre }}">
                    <datalist id="gruposFilterList">
                        @foreach($grupos as $grupo)
                            <option value="{{ $grupo->nombre }}" data-id="{{ $grupo->id }}"></option>
                        @endforeach
                    </datalist>
                    <input type="hidden" name="filter_grupo_id" id="filter_grupo_id_hidden" value="{{ $grupoSeleccionado }}">
                </div>
                <div class="bg-white rounded-md p-3 min-w-0 flex-1 md:max-w-xs">
                    <label for="filter_alumno" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Alumno</label>
                    <input type="text" name="filter_alumno" id="filter_alumno" class="block w-full border-gray-300 rounded-md shadow-sm px-3 py-2" placeholder="Buscar por nombre..." value="{{ $alumnoFiltro }}" onkeydown="if(event.key === 'Enter') { event.preventDefault(); document.getElementById('filterForm').submit(); }">
                </div>
                <div class="flex items-end">
                    <a href="{{ route('inscripciones') }}" class="text-indigo-600 hover:text-indigo-800 underline flex items-center gap-1">
                        <i class="fa-solid fa-eraser"></i>Limpiar filtros
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Formulario para registrar nueva inscripcion -->
    <div class="mt-6 bg-white border border-blue-100 rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold mb-4 text-blue-800">Registrar Nueva Inscripción</h2>
        <form action="{{ route('inscripciones') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700">Nombre del Alumno</label>
                    <input type="text" id="user_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm px-3 py-2" placeholder="Buscar usuario..." list="usersList" onchange="setUser('user_id', 'user_name')" required>
                    <datalist id="usersList">
                        @foreach($users as $user)
                            <option value="{{ $user->name }}" data-id="{{ $user->id }}"></option>
                        @endforeach
                    </datalist>
                    <input type="hidden" name="user_id" id="user_id">
                </div>
                <div>
                    <label for="grupo_id" class="block text-sm font-medium text-gray-700">Grupo</label>
                    <input type="text" id="grupo_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm px-3 py-2" placeholder="Buscar grupo..." list="gruposList" onchange="setGrupo('grupo_id', 'grupo_name')" required>
                    <datalist id="gruposList">
                        @foreach($grupos as $grupo)
                            <option value="{{ $grupo->nombre }}" data-id="{{ $grupo->id }}"></option>
                        @endforeach
                    </datalist>
                    <input type="hidden" name="grupo_id" id="grupo_id">
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Finalizar Inscripción</button>
            </div>
        </form>
    </div>

    <div class="mt-6 overflow-x-auto">
        <table class="min-w-full bg-white shadow rounded-xl border border-gray-200">
            <thead class="bg-blue-50">
                <tr>
                    <th class="py-2 px-4 text-left">ID</th> 
                     <th class="py-2 px-4 text-left">Clave Institucional</th>
                    <th class="py-2 px-4 text-left">Nombre del Alumno</th>
                    <th class="py-2 px-4 text-left">Grupo</th>
                    <th class="py-2 px-4 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inscripciones as $inscripcion)
                    <tr>
                        <td class="py-2 px-4">{{ $inscripcion->id }}</td>  
                         <td class="py-2 px-4">{{ $inscripcion->user->clave_institucional }}</td>
                        <td class="py-2 px-4">{{ $inscripcion->user->name }}</td>
                        <td class="py-2 px-4">{{ $inscripcion->grupo->nombre }}</td>
                        <td class="py-2 px-4 flex space-x-2">
                            <a href="{{ route('inscripciones.edit', $inscripcion->id) }}" class="text-blue-600 hover:text-blue-800"><i class="fa-solid fa-pen-to-square"></i></a>
                            <form action="{{ route('inscripciones.delete', $inscripcion->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de que quieres borrar esta inscripción?')"
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-2 px-4 text-center text-gray-500">No hay inscripciones registradas</td>
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

    function setGrupo(hiddenId, inputName) {
        const input = document.getElementById(inputName);
        const hidden = document.getElementById(hiddenId);
        const claveInput = document.getElementById('clave');
        const datalist = document.getElementById('gruposList');
        
        if (input.value) {
            const option = Array.from(datalist.options).find(opt => opt.value === input.value);
            if (option && option.dataset.id) {
                hidden.value = option.dataset.id;
                claveInput.value = option.dataset.clave || '';
            } else {
                hidden.value = '';
                claveInput.value = '';
            }
        } else {
            hidden.value = '';
            claveInput.value = '';
        }
    }

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