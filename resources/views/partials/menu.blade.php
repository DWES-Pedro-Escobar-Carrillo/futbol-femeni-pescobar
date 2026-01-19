<nav class="bg-white border-b border-gray-100 p-4">
    <div class="flex justify-between items-center max-w-7xl mx-auto">
        <ul class="flex gap-4 list-none p-0 m-0">
            <li><a href="{{ route('welcome') }}" class="font-medium hover:text-gray-600 text-gray-800">Inici</a></li>
            <li><a href="{{ route('estadis.index') }}" class="font-medium hover:text-gray-600 text-gray-800">Estadis</a></li>
            <li><a href="{{ route('equips.index') }}" class="font-medium hover:text-gray-600 text-gray-800">Guia d'Equips</a></li>
            <li><a href="{{ route('jugadores.index') }}" class="font-medium hover:text-gray-600 text-gray-800">Jugadores</a></li>
            <li><a href="{{ route('partits.index') }}" class="font-medium hover:text-gray-600 text-gray-800">Partits</a></li>
        </ul>

        <div class="flex items-center gap-4">
            @if (Route::has('login'))
                @auth
                    {{-- Si l'usuari està loguejat --}}
                    <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900 underline">Dashboard</a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800 ml-2">
                            Sortir
                        </button>
                    </form>
                @else
                    {{-- Si l'usuari NO està loguejat (Convidat) --}}
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900 underline">Iniciar Sessió</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 text-sm font-medium text-gray-700 hover:text-gray-900 underline">Registrar-se</a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</nav>