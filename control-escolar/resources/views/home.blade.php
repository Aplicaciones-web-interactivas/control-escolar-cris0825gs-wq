@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold">Bienvenido, {{ Auth::user()->name }}</h1>
    <p class="text-gray-600">Has iniciado sesión exitosamente en el sistema de Control Escolar.</p>

    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6 flex flex-col">
            <h5 class="text-lg font-medium">Dashboard</h5>
            <p class="text-gray-500 mt-2">Visualiza las estadísticas generales del sistema.</p>
            <a href="/dashboard" class="mt-auto inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Ir al Dashboard</a>
        </div>
        <div class="bg-white rounded-lg shadow p-6 flex flex-col">
            <h5 class="text-lg font-medium">Materias</h5>
            <p class="text-gray-500 mt-2">Consulta y gestiona las materias disponibles.</p>
            <a href="/materias" class="mt-auto inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Ver Materias</a>
        </div>
        <div class="bg-white rounded-lg shadow p-6 flex flex-col">
            <h5 class="text-lg font-medium">Mi Perfil</h5>
            <p class="text-gray-500 mt-2">Edita tu información personal.</p>
            <a href="/profile" class="mt-auto inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Mi Perfil</a>
        </div>
    </div>
</div>
@endsection
