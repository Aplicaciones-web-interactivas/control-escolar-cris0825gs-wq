@extends('layouts.app')

@section('title','Revisar Tarea')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-pink-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl shadow-2xl p-8 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2">{{ $tarea->titulo }}</h1>
                    <p class="text-purple-100 text-lg">Revisa las entregas de tus alumnos</p>
                </div>
                <div class="hidden md:block">
                    <i class="fas fa-check-circle w-20 h-20 text-white opacity-20"></i>
                </div>
            </div>
        </div>

        <!-- Task Information Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center mb-4">
                    <div class="bg-purple-100 p-3 rounded-full mr-4">
                        <i class="fas fa-users text-purple-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Grupo</p>
                        <p class="text-xl font-bold text-gray-900">{{ $tarea->grupo->nombre }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-pink-500 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center mb-4">
                    <div class="bg-pink-100 p-3 rounded-full mr-4">
                        <i class="fas fa-book text-pink-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Materia</p>
                        <p class="text-xl font-bold text-gray-900">{{ $tarea->grupo->horario->materia->nombre ?? 'No asignada' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-indigo-500 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center mb-4">
                    <div class="bg-indigo-100 p-3 rounded-full mr-4">
                        <i class="fas fa-calendar text-indigo-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Fecha de Entrega</p>
                        <p class="text-xl font-bold text-gray-900">{{ $tarea->fecha_entrega ? \Carbon\Carbon::parse($tarea->fecha_entrega)->format('d/m/Y') : 'Sin fecha' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description Section -->
        @if($tarea->descripcion)
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8 border-l-4 border-purple-500">
                <div class="flex items-center mb-6">
                    <div class="bg-purple-100 p-3 rounded-full mr-4">
                        <i class="fas fa-file-alt text-purple-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Descripción de la Tarea</h3>
                </div>
                <div class="bg-gray-50 rounded-lg p-6">
                    <p class="text-gray-700 leading-relaxed text-lg">{{ $tarea->descripcion }}</p>
                </div>
            </div>
        @endif

        <!-- Submissions Section -->
        <div class="bg-white rounded-xl shadow-lg p-8 border-l-4 border-indigo-500">
            <div class="flex items-center mb-6">
                <div class="bg-indigo-100 p-3 rounded-full mr-4">
                    <i class="fas fa-upload text-indigo-600"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Entregas de Alumnos</h2>
            </div>

            @if($tarea->entregas->isEmpty())
                <div class="text-center py-16 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl border-2 border-dashed border-gray-300">
                    <i class="fas fa-file-alt mx-auto h-16 w-16 text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay entregas aún</h3>
                    <p class="text-gray-500">Los alumnos aún no han entregado esta tarea.</p>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($tarea->entregas as $entrega)
                        <div class="bg-gradient-to-r from-white to-gray-50 rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div class="bg-blue-100 p-3 rounded-full mr-4">
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">{{ $entrega->alumno->name }}</h3>
                                        <p class="text-sm text-gray-500">Entregado el {{ $entrega->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    @if($entrega->revisada)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check w-4 h-4 mr-1"></i>
                                            Revisada
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock w-4 h-4 mr-1"></i>
                                            Pendiente
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-white rounded-lg p-4 border border-gray-200">
                                    <h4 class="font-semibold text-gray-900 mb-4">Archivo Entregado</h4>
                                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 border border-blue-200">
                                        <div class="flex items-start justify-between mb-3">
                                            <div class="flex items-start">
                                                <i class="fas fa-file-pdf text-red-500 w-8 h-8 mr-3 flex-shrink-0 mt-1"></i>
                                                <div class="flex-1">
                                                    <p class="text-base font-bold text-gray-900 break-all">{{ basename($entrega->archivo) }}</p>
                                                    <p class="text-xs text-gray-600 mt-1">Entregado: {{ $entrega->created_at->format('d/m/Y H:i:s') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{ route('tareas.entrega.descargar', ['tareaId' => $tarea->id, 'entregaId' => $entrega->id]) }}"
                                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 w-full justify-center">
                                            <i class="fas fa-download w-4 h-4 mr-2"></i>
                                            Descargar PDF
                                        </a>
                                    </div>
                                </div>

                                <div class="bg-white rounded-lg p-4 border border-gray-200">
                                    <form action="{{ route('tareas.entrega.revisar', ['tareaId' => $tarea->id, 'entregaId' => $entrega->id]) }}" method="POST">
                                        @csrf
                                        <h4 class="font-semibold text-gray-900 mb-3">Revisar Entrega</h4>
                                        <div class="mb-4">
                                            <label for="comentario_{{ $entrega->id }}" class="block text-sm font-medium text-gray-700 mb-2">Comentario (Opcional)</label>
                                            <textarea name="comentario" id="comentario_{{ $entrega->id }}" rows="3"
                                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-none"
                                                      placeholder="Agrega un comentario sobre la entrega...">{{ $entrega->comentario }}</textarea>
                                        </div>
                                        <input type="hidden" name="revisada" value="1">
                                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform hover:scale-105 transition-all duration-200">
                                            <i class="fas fa-check w-4 h-4 mr-2"></i>
                                            Marcar como Revisada
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Back Button -->
        <div class="mt-8 text-center">
            <a href="{{ route('tareas.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transform hover:scale-105 transition-all duration-200">
                <i class="fas fa-arrow-left w-5 h-5 mr-2"></i>
                Regresar a Tareas
            </a>
        </div>
    </div>
</div>
@endsection