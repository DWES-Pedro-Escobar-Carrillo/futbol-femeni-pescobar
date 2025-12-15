<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $equip->nom }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                {{-- Detalles del equipo --}}
                <div class="flex items-center mb-6">
                    @if($equip->escut)
                        <img src="{{ asset('storage/' . $equip->escut) }}" alt="Escut" class="w-24 h-24 mr-4">
                    @endif
                    <div>
                        <h3 class="text-2xl font-bold">{{ $equip->nom }}</h3>
                        <p class="text-gray-600">Estadi: {{ $equip->estadi->nom ?? 'Sense estadi' }}</p>
                        <p class="text-gray-600">Títols: {{ $equip->titols }}</p>
                    </div>
                </div>

                {{-- Botones de Acción (Editar/Borrar) --}}
                <div class="mb-6 flex space-x-2">
                    @can('update', $equip)
                        <a href="{{ route('equips.edit', $equip) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            Editar Equip
                        </a>
                    @endcan

                    @can('delete', $equip)
                        <form action="{{ route('equips.destroy', $equip) }}" method="POST" onsubmit="return confirm('Segur que vols esborrar aquest equip?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Esborrar Equip
                            </button>
                        </form>
                    @endcan
                </div>

                {{-- Sección Jugadoras --}}
                <div class="border-t pt-6">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-xl font-bold">Plantilla</h4>
                        
                        {{-- Botón añadir jugadora: Si tiene permiso general de crear y (si es manager) es SU equipo --}}
                        @can('create', App\Models\Jugadora::class)
                            @if(Auth::user()->role === 'admin' || Auth::user()->team_id === $equip->id)
                                <a href="{{ route('jugadores.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-1 px-3 rounded">
                                    + Afegir Jugadora
                                </a>
                            @endif
                        @endcan
                    </div>
                    
                    {{-- Usamos el componente existente --}}
                    <x-jugadores-equip-llista :jugadores="$equip->jugadores" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>