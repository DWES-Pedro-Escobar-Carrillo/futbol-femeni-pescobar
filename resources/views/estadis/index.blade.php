<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Guia d'Estadis") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Només Admin pot crear estadis --}}
                @can('create', App\Models\Estadi::class)
                    <p class="mb-4">
                        <a href="{{ route('estadis.create') }}" class="bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700 transition">
                            + Nou Estadi
                        </a>
                    </p>
                @endcan

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-300">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border border-gray-300 p-2 text-left">Nom</th>
                                <th class="border border-gray-300 p-2 text-left">Capacitat</th>
                                <th class="border border-gray-300 p-2 text-left">Accions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($estadis as $estadi)
                            <tr class="hover:bg-gray-100 transition">
                                <td class="border border-gray-300 p-2">
                                    <a href="{{ route('estadis.show', $estadi) }}" class="text-blue-700 hover:underline font-bold">
                                        {{ $estadi->nom }}
                                    </a>
                                </td>
                                <td class="border border-gray-300 p-2">{{ number_format($estadi->capacitat, 0, ',', '.') }} espectadors</td>
                                <td class="border border-gray-300 p-2">
                                    <div class="flex items-center space-x-3">
                                        @can('update', $estadi)
                                            <a href="{{ route('estadis.edit', $estadi) }}" class="text-yellow-600 hover:text-yellow-800 font-medium hover:underline">
                                                Editar
                                            </a>
                                        @endcan

                                        @can('delete', $estadi)
                                            <form action="{{ route('estadis.destroy', $estadi) }}" method="POST" class="inline-block" onsubmit="return confirm('Estàs segur?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium hover:underline">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>