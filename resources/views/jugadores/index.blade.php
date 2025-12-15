<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Guia de Jugadores") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Missatges de feedback --}}
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Botó Crear: Només Admin o Manager --}}
                @can('create', App\Models\Jugadora::class)
                    <p class="mb-4">
                        <a href="{{ route('jugadores.create') }}" class="bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700 transition">
                            + Nova jugadora
                        </a>
                    </p>
                @endcan

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-300">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border border-gray-300 p-2 text-left">Nom</th>
                                <th class="border border-gray-300 p-2 text-left">Posició</th>
                                <th class="border border-gray-300 p-2 text-left">Equip</th>
                                <th class="border border-gray-300 p-2 text-left">Accions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($jugadores as $jugadora)
                            <tr class="hover:bg-gray-100 transition">
                                <td class="border border-gray-300 p-2 font-medium text-gray-900">
                                    <a href="{{ route('jugadores.show', $jugadora) }}" class="text-blue-700 hover:underline">
                                        {{ $jugadora->nom }}
                                    </a>
                                </td>
                                <td class="border border-gray-300 p-2">{{ $jugadora->posicio }}</td>
                                <td class="border border-gray-300 p-2">
                                    @if($jugadora->equip)
                                        <a href="{{ route('equips.show', $jugadora->equip) }}" class="text-blue-600 hover:underline">
                                            {{ $jugadora->equip->nom }}
                                        </a>
                                    @else
                                        <span class="text-gray-500 italic">Sense equip</span>
                                    @endif
                                </td>
                                <td class="border border-gray-300 p-2">
                                    <div class="flex items-center space-x-3">
                                        {{-- Botó Editar --}}
                                        @can('update', $jugadora)
                                            <a href="{{ route('jugadores.edit', $jugadora) }}" class="text-yellow-600 hover:text-yellow-800 font-medium hover:underline">
                                                Editar
                                            </a>
                                        @endcan

                                        {{-- Botó Eliminar --}}
                                        @can('delete', $jugadora)
                                            <form action="{{ route('jugadores.destroy', $jugadora) }}" method="POST" class="inline-block" onsubmit="return confirm('Segur que vols eliminar aquesta jugadora?');">
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