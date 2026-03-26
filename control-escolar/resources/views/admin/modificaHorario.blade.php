@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold">Editar Horario</h1>
    <p class="text-gray-600">Modifica los datos del horario</p>

    @if(session('success'))
        <div id="alert-success" class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded transition-opacity duration-300">
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
        <form action="{{ route('horarios.update', $horario->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700">Usuario</label>
                    <input type="text" id="user_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm px-3 py-2" placeholder="Buscar usuario..." list="usersList" onchange="setUser('user_id', 'user_name')" value="{{ $horario->user->name }}" required>
                    <datalist id="usersList">
                        @foreach($users as $user)
                            <option value="{{ $user->name }}" data-id="{{ $user->id }}"></option>
                        @endforeach
                    </datalist>
                    <input type="hidden" name="user_id" id="user_id" value="{{ $horario->user_id }}">
                </div>
                <div>
                    <label for="materia_id" class="block text-sm font-medium text-gray-700">Materia</label>
                    <input type="text" id="materia_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm px-3 py-2" placeholder="Buscar materia..." list="materiasList" onchange="setMateria('materia_id', 'materia_name')" value="{{ $horario->materia->nombre }}" required>
                    <datalist id="materiasList">
                        @foreach($materias as $materia)
                            <option value="{{ $materia->nombre }}" data-id="{{ $materia->id }}"></option>
                        @endforeach
                    </datalist>
                    <input type="hidden" name="materia_id" id="materia_id" value="{{ $horario->materia_id }}">
                </div>
                <div>
                    <label for="hora_inicio" class="block text-sm font-medium text-gray-700">Hora Inicio</label>
                    <input type="time" name="hora_inicio" id="hora_inicio" value="{{ $horario->hora_inicio }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div>
                    <label for="hora_fin" class="block text-sm font-medium text-gray-700">Hora Fin</label>
                    <input type="time" name="hora_fin" id="hora_fin" value="{{ $horario->hora_fin }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
            </div>
            <div class="mt-4 flex space-x-4">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Actualizar Horario</button>
                <a href="{{ route('horarios') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection

<script>
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