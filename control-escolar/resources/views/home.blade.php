@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white border border-blue-100 rounded-xl shadow-lg p-6 mb-6">
        <h1 class="text-3xl font-bold text-blue-900">Bienvenido, {{ Auth::user()->name }}</h1>
        <p class="text-gray-600 mt-1">Has iniciado sesión exitosamente en el sistema de Control Escolar.</p>
    </div>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-lg border border-blue-100 p-6 flex flex-col transition hover:-translate-y-1 hover:shadow-xl">
            <h5 class="text-lg font-semibold text-blue-900">Dashboard</h5>
            <p class="text-gray-500 mt-2">Visualiza las estadísticas generales del sistema.</p>
            <a href="/dashboard" class="mt-auto inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Ir al Dashboard</a>
        </div>
        <div class="bg-white rounded-xl shadow-lg border border-blue-100 p-6 flex flex-col transition hover:-translate-y-1 hover:shadow-xl">
            <h5 class="text-lg font-semibold text-blue-900">Materias</h5>
            <p class="text-gray-500 mt-2">Consulta y gestiona las materias disponibles.</p>
            <a href="/materias" class="mt-auto inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Ver Materias</a>
        </div>
        <div class="bg-white rounded-xl shadow-lg border border-blue-100 p-6 flex flex-col transition hover:-translate-y-1 hover:shadow-xl">
            <h5 class="text-lg font-semibold text-blue-900">Mi Perfil</h5>
            <p class="text-gray-500 mt-2">Edita tu información personal.</p>
            <a href="/profile" class="mt-auto inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Mi Perfil</a>
        </div>
    </div>
</div>
@endsection
