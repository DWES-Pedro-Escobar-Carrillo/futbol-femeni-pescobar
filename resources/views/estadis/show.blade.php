<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $estadi->nom }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-2xl font-bold mb-4">Informació</h3>
                <p><strong>Nom:</strong> {{ $estadi->nom }}</p>
                <p><strong>Capacitat:</strong> {{ $estadi->capacitat }} espectadors</p>

                <div class="mt-6 flex space-x-3">
                    @can('update', $estadi)
                        <a href="{{ route('estadis.edit', $estadi) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            Editar Estadi
                        </a>
                    @endcan

                    @can('delete', $estadi)
                        <form action="{{ route('estadis.destroy', $estadi) }}" method="POST" onsubmit="return confirm('Eliminar estadi?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Eliminar Estadi
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>