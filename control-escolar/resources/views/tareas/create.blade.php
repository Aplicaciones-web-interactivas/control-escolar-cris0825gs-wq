@extends('layouts.app')

@section('title','Crear Tarea')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-blue-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-green-600 to-blue-600 rounded-2xl shadow-2xl p-8 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2">Crear Nueva Tarea</h1>
                    <p class="text-green-100 text-lg">Asigna una nueva tarea a uno de tus grupos</p>
                </div>
                <div class="hidden md:block">
                    <i class="fas fa-moon w-20 h-20 text-white opacity-20"></i>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 border-l-4 border-green-500">
            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Hay errores en el formulario:</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul role="list" class="list-disc pl-5 space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('tareas.store') }}" method="POST" class="space-y-8">
                @csrf

                <!-- Grupo Selection -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200">
                    <div class="flex items-center mb-4">
                        <div class="bg-blue-100 p-3 rounded-full mr-4">
                            <i class="fas fa-users text-blue-600"></i>
                        </div>
                        <label class="text-xl font-bold text-gray-900">Seleccionar Grupo</label>
                    </div>
                    <select name="grupo_id" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white" required>
                        <option value="">Selecciona un grupo para asignar la tarea</option>
                        @foreach($grupos as $grupo)
                            <option value="{{ $grupo->id }}" {{ old('grupo_id') == $grupo->id ? 'selected' : '' }}>
                                {{ $grupo->nombre }} - {{ $grupo->horario->materia->nombre ?? 'Sin materia' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Título -->
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-200">
                    <div class="flex items-center mb-4">
                        <div class="bg-purple-100 p-3 rounded-full mr-4">
                            <i class="fas fa-tag text-purple-600"></i>
                        </div>
                        <label class="text-xl font-bold text-gray-900">Título de la Tarea</label>
                    </div>
                    <input type="text" name="titulo" value="{{ old('titulo') }}" placeholder="Ingresa un título descriptivo para la tarea"
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 bg-white" required>
                </div>

                <!-- Descripción -->
                <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl p-6 border border-yellow-200">
                    <div class="flex items-center mb-4">
                        <div class="bg-yellow-100 p-3 rounded-full mr-4">
                            <i class="fas fa-file-alt text-yellow-600"></i>
                        </div>
                        <label class="text-xl font-bold text-gray-900">Descripción (Opcional)</label>
                    </div>
                    <textarea name="descripcion" rows="5" placeholder="Describe los detalles de la tarea, instrucciones, requisitos, etc."
                              class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200 bg-white resize-vertical">{{ old('descripcion') }}</textarea>
                </div>

                <!-- Fecha de Entrega -->
                <div class="bg-gradient-to-r from-green-50 to-teal-50 rounded-xl p-6 border border-green-200">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-100 p-3 rounded-full mr-4">
                            <i class="fas fa-calendar text-green-600"></i>
                        </div>
                        </div>
                        <label class="text-xl font-bold text-gray-900">Fecha de Entrega (Opcional)</label>
                    </div>
                    <input type="date" name="fecha_entrega" value="{{ old('fecha_entrega') }}"
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-white">
                    <p class="text-sm text-gray-600 mt-2">Si no especificas una fecha, la tarea no tendrá límite de tiempo.</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-end pt-6 border-t border-gray-200">
                    <a href="{{ route('tareas.index') }}" class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transform hover:scale-105 transition-all duration-200">
                        <i class="fas fa-times w-5 h-5 mr-2"></i>
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform hover:scale-105 transition-all duration-200">
                        <i class="fas fa-plus w-5 h-5 mr-2"></i>
                        Crear Tarea
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection