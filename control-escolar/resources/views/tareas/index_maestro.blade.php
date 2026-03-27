@extends('layouts.app')

@section('title','Tareas - Maestro')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="bg-blue-600 text-white p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold">Mis Tareas Asignadas</h1>
                    <p class="text-blue-100 mt-1">Gestiona las tareas que has creado para tus grupos</p>
                </div>
                <a href="{{ route('tareas.create') }}" class="bg-white text-blue-600 font-semibold py-2 px-4 rounded hover:bg-gray-100">
                    Crear Nueva Tarea
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-400 p-4 m-6 mt-4">
                <p class="text-green-700">{{ session('success') }}</p>
            </div>
        @endif

        <div class="p-6">
            @if($tareas->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-500 text-lg">No hay tareas asignadas aún.</p>
                    <p class="text-gray-400 mt-2">Comienza creando tu primera tarea para un grupo.</p>
                    <a href="{{ route('tareas.create') }}" class="mt-4 inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                        Crear Primera Tarea
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Grupo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Materia</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Título</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Entrega</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($tareas as $tarea)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">#{{ $tarea->id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $tarea->grupo->nombre }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $tarea->grupo->horario->materia->nombre ?? 'N/D' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    <div class="font-medium">{{ $tarea->titulo }}</div>
                                    @if($tarea->descripcion)
                                        <div class="text-gray-500 text-xs">{{ Str::limit($tarea->descripcion, 50) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    @if($tarea->fecha_entrega)
                                        <span class="{{ \Carbon\Carbon::parse($tarea->fecha_entrega)->isPast() ? 'text-red-600' : 'text-green-600' }}">
                                            {{ \Carbon\Carbon::parse($tarea->fecha_entrega)->format('d/m/Y') }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">Sin fecha</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <a href="{{ route('tareas.show', $tarea->id) }}" class="text-blue-600 hover:text-blue-800">
                                        Ver / Revisar
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