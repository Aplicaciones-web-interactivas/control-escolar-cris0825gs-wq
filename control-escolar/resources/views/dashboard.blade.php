@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-blue-900">Panel de Control</h1>
                <p class="text-gray-600 mt-1">Bienvenido, <span class="font-semibold text-gray-800">{{ auth()->user()->name }}</span> (<span class="text-indigo-600">{{ auth()->user()->clave_institucional }}</span>)</p>
            </div>
            <div class="text-right">
                <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800">Activo</span>
            </div>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-lg border border-blue-100 p-6 transition hover:shadow-xl hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase">Total de Alumnos</p>
                    <p class="mt-2 text-4xl font-bold text-blue-900">0</p>
                </div>
                <div class="bg-blue-50 text-blue-600 p-3 rounded-full">
                    <i class="fa-solid fa-graduation-cap fa-lg"></i>
                </div>
            </div>
            <p class="mt-3 text-xs text-gray-400">Métrica actualizada en tiempo real</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-blue-100 p-6 transition hover:shadow-xl hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase">Materias</p>
                    <p class="mt-2 text-4xl font-bold text-blue-900">3</p>
                </div>
                <div class="bg-blue-50 text-blue-600 p-3 rounded-full">
                    <i class="fa-solid fa-book fa-lg"></i>
                </div>
            </div>
            <p class="mt-3 text-xs text-gray-400">Revisa todas las materias disponibles</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-blue-100 p-6 transition hover:shadow-xl hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase">Profesores</p>
                    <p class="mt-2 text-4xl font-bold text-blue-900">0</p>
                </div>
                <div class="bg-blue-50 text-blue-600 p-3 rounded-full">
                    <i class="fa-solid fa-chalkboard-user fa-lg"></i>
                </div>
            </div>
            <p class="mt-3 text-xs text-gray-400">Datos de docentes en el sistema</p>
        </div>
    </div>
</div>
@endsection