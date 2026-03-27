@extends('layouts.app')

@section('title','Tareas - Alumno')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 text-white p-6">
            <div class="flex items-center">
                <i class="fas fa-book w-8 h-8 mr-3"></i>
                <div>
                    <h1 class="text-3xl font-bold">Mis Tareas</h1>
                    <p class="text-indigo-100 mt-1">Revisa y entrega tus tareas asignadas</p>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="mx-6 mt-4 bg-green-50 border-l-4 border-green-400 p-4 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check text-green-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="p-6">
            @if($tareas->isEmpty())
                <div class="text-center py-12">
                    <i class="fas fa-file-alt mx-auto h-24 w-24 text-gray-400"></i>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No tienes tareas asignadas</h3>
                    <p class="mt-2 text-gray-500">Cuando tu maestro asigne tareas, aparecerán aquí.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grupo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Materia</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Entrega</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($tareas as $tarea)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $tarea->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center">
                                                <span class="text-xs font-medium text-white">{{ substr($tarea->grupo->nombre, 0, 2) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $tarea->grupo->nombre }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $tarea->grupo->horario->materia->nombre ?? 'N/D' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 font-medium">{{ $tarea->titulo }}</div>
                                    @if($tarea->descripcion)
                                        <div class="text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($tarea->descripcion, 50) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($tarea->fecha_entrega)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ \Carbon\Carbon::parse($tarea->fecha_entrega)->isPast() ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ \Carbon\Carbon::parse($tarea->fecha_entrega)->format('d/m/Y') }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">Sin fecha</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $entrega = $tarea->entregas->where('alumno_id', auth()->id())->first();
                                    @endphp
                                    @if($entrega)
                                        @if($entrega->revisada)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check w-4 h-4 mr-1"></i>
                                                Revisada
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock w-4 h-4 mr-1"></i>
                                                Entregada
                                            </span>
                                        @endif
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-exclamation-triangle w-4 h-4 mr-1"></i>
                                            Pendiente
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('tareas.show', $tarea->id) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 transition duration-150">
                                        <i class="fas fa-eye w-4 h-4 mr-2"></i>
                                        Ver / Entregar
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection