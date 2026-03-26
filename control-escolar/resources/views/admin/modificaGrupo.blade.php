@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold">Editar Grupo</h1>
    <p class="text-gray-600">Modifica los datos del grupo</p>

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
        <form action="{{ route('grupos.update', $grupo->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="horario_id" class="block text-sm font-medium text-gray-700">Horario</label>
                    <input type="text" id="horario_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm px-3 py-2" placeholder="Buscar horario..." list="horariosList" onchange="setHorario('horario_id', 'horario_name')" value="{{ $grupo->horario->materia->nombre }} - {{ $grupo->horario->user->name }} ({{ $grupo->horario->hora_inicio }} - {{ $grupo->horario->hora_fin }})" required>
                    <datalist id="horariosList">
                        @foreach($horarios as $horario)
                            <option value="{{ $horario->materia->nombre }} - {{ $horario->user->name }} ({{ $horario->hora_inicio }} - {{ $horario->hora_fin }})" data-id="{{ $horario->id }}"></option>
                        @endforeach
                    </datalist>
                    <input type="hidden" name="horario_id" id="horario_id" value="{{ $grupo->horario_id }}">
                </div>
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del Grupo</label>
                    <input type="text" name="nombre" id="nombre" value="{{ $grupo->nombre }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
            </div>
            <div class="mt-4 flex space-x-4">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Actualizar Grupo</button>
                <a href="{{ route('grupos') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Cancelar</a>
            </div>
        </form>
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