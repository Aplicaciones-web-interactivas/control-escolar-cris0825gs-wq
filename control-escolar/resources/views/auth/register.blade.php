<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registro</title>
@vite('resources/css/app.css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>

<body class="min-h-screen bg-gradient-to-r flex items-center justify-center">
    <div> </div>

    <div class="bg-blue-200 w-full max-w-md rounded-2xl shadow-2xl p-10">
        <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Crear cuenta</h1>
        <p class="text-gray-500 text-sm">Regístrate para continuar</p>
    </div>

    <form method="POST" action="/register" class="space-y-5 bg-white p-6 rounded-lg shadow-md">
@csrf

<div>
<label class="text-sm text-gray-600">Nombre</label>
<input 
    type="text"
    name="name"
    value="{{ old('name') }}"
    placeholder="Tu nombre"
    class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none">
@error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
</div>

<div>
<label class="text-sm text-gray-600">Clave institucional</label>
<input 
    type="text"
    name="clave_institucional"
    value="{{ old('clave_institucional') }}"
    placeholder="Clave institucional"
    class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none">
@error('clave_institucional')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
</div>

<div>
<label class="text-sm text-gray-600">Contraseña</label>
<input 
    type="password"
    name="password"
    placeholder="********"
    class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none">
@error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
</div>

<div>
<label class="text-sm text-gray-600">Tipo de usuario</label>
<select name="role" class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none">
    <option value="alumno" {{ old('role') === 'alumno' ? 'selected' : '' }}>Alumno</option>
    <option value="maestro" {{ old('role') === 'maestro' ? 'selected' : '' }}>Maestro</option>
</select>
@error('role')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
</div>

<div>
<label class="text-sm text-gray-600">Confirmar contraseña</label>
<input 
    type="password"
    name="password_confirmation"
    placeholder="********"
    class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none">
</div>

<button
    type="submit"
    class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition duration-300 font-semibold">
    Registrarme
</button>

</form>

<div class="text-center mt-6 text-sm text-gray-500">
¿Ya tienes cuenta?
<a href="/" class="text-indigo-600 font-semibold hover:underline">Iniciar sesión</a>
</div>

    </div>

</body>
</html>