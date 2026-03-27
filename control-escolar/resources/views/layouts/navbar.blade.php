<nav class="w-64 bg-blue-900 shadow h-full fixed left-0 top-0 overflow-y-auto">
    <div class="p-4">
        <a href="/" class="text-xl font-bold text-white block mb-4">CONTROL ESCOLAR</a>
        <div class="space-y-2 ">
            @auth
                <a href="/home" class="block py-2 px-4 {{ request()->is('home') ? 'font-semibold text-blue-900 bg-gray-200 rounded-lg' : 'text-white hover:text-blue-900 hover:bg-gray-100 rounded-lg' }}"><i class="fa-solid fa-house m-2"></i>Home</a>
                <a href="/dashboard" class="block py-2 px-4 {{ request()->is('dashboard') ? 'font-semibold text-blue-900 bg-gray-200 rounded-lg' : 'text-white hover:text-blue-900 hover:bg-gray-100 rounded-lg' }}"><i class="fa-solid fa-chart-bar m-2"></i>Dashboard</a>
                <a href="/materias" class="block py-2 px-4 {{ request()->is('materias*') ? 'font-semibold text-blue-900 bg-gray-200 rounded-lg' : 'text-white hover:text-blue-900 hover:bg-gray-100 rounded-lg' }}"><i class="fa-solid fa-book m-2"></i>Materias</a>
                <a href="/horarios" class="block py-2 px-4 {{ request()->is('horarios*') ? 'font-semibold text-blue-900 bg-gray-200 rounded-lg' : 'text-white hover:text-blue-900 hover:bg-gray-100 rounded-lg' }}"><i class="fa-solid fa-clock m-2"></i>Horarios</a>
                <a href="/grupos" class="block py-2 px-4 {{ request()->is('grupos*') ? 'font-semibold text-blue-900 bg-gray-200 rounded-lg' : 'text-white hover:text-blue-900 hover:bg-gray-100 rounded-lg' }}"><i class="fa-solid fa-users m-2"></i>Grupos</a>
                <a href="/inscripciones" class="block py-2 px-4 {{ request()->is('inscripciones*') ? 'font-semibold text-blue-900 bg-gray-200 rounded-lg' : 'text-white hover:text-blue-900 hover:bg-gray-100 rounded-lg' }}"><i class="fa-solid fa-user m-2"></i>Inscripciones</a>
                <a href="/calificaciones" class="block py-2 px-4 {{ request()->is('calificaciones*') ? 'font-semibold text-blue-900 bg-gray-200 rounded-lg' : 'text-white hover:text-blue-900 hover:bg-gray-100 rounded-lg' }}"><i class="fa-solid fa-star m-2"></i>Calificaciones</a>
                <a href="/tareas" class="block py-2 px-4 {{ request()->is('tareas*') ? 'font-semibold text-blue-900 bg-gray-200 rounded-lg' : 'text-white hover:text-blue-900 hover:bg-gray-100 rounded-lg' }}"><i class="fa-solid fa-clipboard-list m-2"></i>Tareas</a>
                <form action="{{ route('logout') }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Logout</button>
                </form>
            @else
                <a href="/register" class="block py-2 px-4 text-white hover:text-gray-800 hover:bg-gray-100">Register</a>
                <a href="{{ route('login') }}" class="block py-2 px-4 text-white hover:text-gray-800 hover:bg-gray-100">Login</a>
            @endauth
        </div>
    </div>
</nav>

<script>
    document.getElementById('menu-toggle').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
</script>
