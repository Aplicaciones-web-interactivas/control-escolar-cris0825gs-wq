@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold">Panel de Control</h1>
    <p class="text-gray-600">Bienvenido, {{ auth()->user()->name }} ({{ auth()->user()->clave_institucional }})</p>

    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <h5 class="text-lg font-medium">Usuarios</h5>
            <p class="text-4xl font-semibold mt-2">0</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <h5 class="text-lg font-medium">Materias</h5>
            <p class="text-4xl font-semibold mt-2">3</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <h5 class="text-lg font-medium">Estudiantes</h5>
            <p class="text-4xl font-semibold mt-2">0</p>
        </div>
    </div>
</div>
@endsection