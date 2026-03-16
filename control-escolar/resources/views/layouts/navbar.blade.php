<nav class="bg-white shadow">
    <div class="container mx-auto px-4 py-3">
        <div class="flex justify-between items-center">
            <a href="/" class="text-xl font-bold text-gray-800">Control Escolar</a>
            <div class="hidden md:flex items-center space-x-4">
                @auth
                    <a href="/home" class="text-gray-600 hover:text-gray-800 {{ request()->is('home') ? 'font-semibold text-gray-900' : '' }}">Home</a>
                    <a href="/dashboard" class="text-gray-600 hover:text-gray-800 {{ request()->is('dashboard') ? 'font-semibold text-gray-900' : '' }}">Dashboard</a>
                    <a href="/materias" class="text-gray-600 hover:text-gray-800 {{ request()->is('materias') ? 'font-semibold text-gray-900' : '' }}">Materias</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Logout</button>
                    </form>
                @else
                    <a href="/register" class="text-gray-600 hover:text-gray-800">Register</a>
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-800">Login</a>
                @endauth
            </div>
            <div class="md:hidden">
                <button id="menu-toggle" class="text-gray-600 hover:text-gray-800 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
        <div id="mobile-menu" class="md:hidden hidden mt-4 pb-4">
            @auth
                <a href="/home" class="block py-2 text-gray-600 hover:text-gray-800 {{ request()->is('home') ? 'font-semibold text-gray-900' : '' }}">Home</a>
                <a href="/dashboard" class="block py-2 text-gray-600 hover:text-gray-800 {{ request()->is('dashboard') ? 'font-semibold text-gray-900' : '' }}">Dashboard</a>
                <a href="/materias" class="block py-2 text-gray-600 hover:text-gray-800 {{ request()->is('materias') ? 'font-semibold text-gray-900' : '' }}">Materias</a>
                <form action="{{ route('logout') }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600">Logout</button>
                </form>
            @else
                <a href="/register" class="block py-2 text-gray-600 hover:text-gray-800">Register</a>
                <a href="{{ route('login') }}" class="block py-2 text-gray-600 hover:text-gray-800">Login</a>
            @endauth
        </div>
    </div>
</nav>

<script>
    document.getElementById('menu-toggle').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
</script>
