<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detall del Partit
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partit-fitxa :partit="$partit" />

            <div class="mt-6 flex justify-center space-x-4">
                @can('update', $partit)
                    <a href="{{ route('partits.edit', $partit) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                        {{ Auth::user()->role === 'arbitre' ? 'Modificar Marcador' : 'Editar Dades' }}
                    </a>
                @endcan

                @can('delete', $partit)
                    <form action="{{ route('partits.destroy', $partit) }}" method="POST" onsubmit="return confirm('Esborrar partit?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Eliminar Partit
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>