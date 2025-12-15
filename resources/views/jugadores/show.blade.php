<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Fitxa de Jugadora
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex items-start">
                    @if($jugadora->foto)
                         <img src="{{ asset('storage/' . $jugadora->foto) }}" class="w-32 h-32 object-cover rounded-full mr-6">
                    @endif
                    <div>
                        <h3 class="text-3xl font-bold mb-2">{{ $jugadora->nom }}</h3>
                        <p class="text-lg"><strong>Equip:</strong> {{ $jugadora->equip->nom ?? 'Cap' }}</p>
                        <p class="text-lg"><strong>Dorsal:</strong> {{ $jugadora->dorsal }}</p>
                        <p class="text-lg"><strong>Edat:</strong> {{ $jugadora->edat }} anys</p>
                    </div>
                </div>

                <div class="mt-6 flex space-x-3">
                    @can('update', $jugadora)
                        <a href="{{ route('jugadores.edit', $jugadora) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            Editar Dades
                        </a>
                    @endcan

                    @can('delete', $jugadora)
                        <form action="{{ route('jugadores.destroy', $jugadora) }}" method="POST" onsubmit="return confirm('Segur?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Eliminar Jugadora
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>