@extends('layouts.app')

@section('title','Ver Tarea')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl shadow-2xl p-8 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2">{{ $tarea->titulo }}</h1>
                    <p class="text-blue-100 text-lg">Detalles de la tarea asignada</p>
                </div>
                <div class="hidden md:block">
                    <i class="fas fa-check-circle w-20 h-20 text-white opacity-20"></i>
                </div>
            </div>
        </div>

        <!-- Task Information Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-100 p-3 rounded-full mr-4">
                        <i class="fas fa-users text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Grupo</p>
                        <p class="text-xl font-bold text-gray-900">{{ $tarea->grupo->nombre }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center mb-4">
                    <div class="bg-green-100 p-3 rounded-full mr-4">
                        <i class="fas fa-book text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Materia</p>
                        <p class="text-xl font-bold text-gray-900">{{ $tarea->grupo->horario->materia->nombre ?? 'No asignada' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center mb-4">
                    <div class="bg-orange-100 p-3 rounded-full mr-4">
                        <i class="fas fa-calendar text-orange-600"></i>
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

        <!-- Submission Section -->
        <div class="bg-white rounded-xl shadow-lg p-8 border-l-4 border-indigo-500">
            <div class="flex items-center mb-6">
                <div class="bg-indigo-100 p-3 rounded-full mr-4">
                    <i class="fas fa-upload text-indigo-600"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Mi Entrega</h2>
            </div>

            @if($entrega)
                <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-xl p-6 border border-green-200">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-100 p-2 rounded-full mr-3">
                            <i class="fas fa-check text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Estado</p>
                            <p class="text-lg font-bold text-gray-900">
                                @if($entrega->revisada)
                                    <span class="text-green-600">Revisada ✓</span>
                                @else
                                    <span class="text-yellow-600">Pendiente de revisión</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    @if($entrega->comentario)
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Comentario del maestro</p>
                            <p class="text-gray-700">{{ $entrega->comentario }}</p>
                        </div>
                    @endif
                </div>
            @else
                <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl p-6 border border-yellow-200">
                    <div class="flex items-center mb-4">
                        <div class="bg-yellow-100 p-2 rounded-full mr-3">
                            <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                        </div>
                        <p class="text-lg font-semibold text-gray-900">Aún no has entregado esta tarea</p>
                    </div>

                    <form action="{{ route('tareas.entrega', $tarea->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="entregaForm">
                        @csrf
                        <div class="bg-white rounded-lg p-6 border-2 border-dashed border-gray-300 hover:border-blue-400 transition-colors duration-300">
                            <div class="text-center">
                                <i class="fas fa-cloud-upload-alt mx-auto h-12 w-12 text-gray-400 mb-4"></i>
                                <div class="mt-4">
                                    <label for="archivo" class="cursor-pointer">
                                        <span class="mt-2 block text-sm font-medium text-gray-900">Subir archivo PDF</span>
                                        <input type="file" name="archivo" id="archivo" accept=".pdf" required class="sr-only">
                                        <span class="mt-1 block text-sm text-gray-500">Selecciona un archivo PDF de hasta 10MB</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- File Display Section -->
                        <div id="archivoInfo" class="hidden bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 border border-blue-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-file-pdf text-red-500 w-8 h-8 mr-3"></i>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 uppercase">Archivo seleccionado</p>
                                        <p id="nombreArchivo" class="text-base font-semibold text-gray-900"></p>
                                        <p id="tamañoArchivo" class="text-xs text-gray-600 mt-1"></p>
                                    </div>
                                </div>
                                <button type="button" id="limpiarArchivo" class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-times w-5 h-5"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Error Message -->
                        <div id="archivoError" class="hidden bg-red-50 rounded-lg p-4 border border-red-200">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle text-red-500 w-5 h-5 mr-3"></i>
                                <p id="errorMensaje" class="text-sm font-medium text-red-700"></p>
                            </div>
                        </div>
                        
                        <div class="flex justify-center">
                            <button type="submit" class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:scale-105 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed" id="submitBtn">
                                <i class="fas fa-upload w-5 h-5 mr-2"></i>
                                Entregar Tarea
                            </button>
                        </div>
                    </form>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputArchivo = document.getElementById('archivo');
        const archivoInfo = document.getElementById('archivoInfo');
        const archivoError = document.getElementById('archivoError');
        const nombreArchivo = document.getElementById('nombreArchivo');
        const tamañoArchivo = document.getElementById('tamañoArchivo');
        const limpiarBtn = document.getElementById('limpiarArchivo');
        const errorMensaje = document.getElementById('errorMensaje');
        const submitBtn = document.getElementById('submitBtn');
        const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB en bytes

        inputArchivo.addEventListener('change', function(e) {
            archivoError.classList.add('hidden');
            errorMensaje.textContent = '';

            if (this.files && this.files.length > 0) {
                const file = this.files[0];
                
                // Validar tipo de archivo
                if (file.type !== 'application/pdf') {
                    mostrarError('Por favor selecciona un archivo PDF válido');
                    inputArchivo.value = '';
                    submitBtn.disabled = true;
                    return;
                }
                
                // Validar tamaño
                if (file.size > MAX_FILE_SIZE) {
                    mostrarError(`El archivo es muy grande. Máximo permitido: 10MB. Tamaño actual: ${(file.size / 1024 / 1024).toFixed(2)}MB`);
                    inputArchivo.value = '';
                    submitBtn.disabled = true;
                    return;
                }
                
                // Mostrar información del archivo
                nombreArchivo.textContent = file.name;
                tamañoArchivo.textContent = `Tamaño: ${(file.size / 1024).toFixed(2)} KB`;
                archivoInfo.classList.remove('hidden');
                submitBtn.disabled = false;
            } else {
                archivoInfo.classList.add('hidden');
                submitBtn.disabled = true;
            }
        });

        limpiarBtn.addEventListener('click', function(e) {
            e.preventDefault();
            inputArchivo.value = '';
            archivoInfo.classList.add('hidden');
            archivoError.classList.add('hidden');
            submitBtn.disabled = true;
        });

        function mostrarError(mensaje) {
            errorMensaje.textContent = mensaje;
            archivoError.classList.remove('hidden');
            archivoInfo.classList.add('hidden');
        }
    });
</script>
@endsection
