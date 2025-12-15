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
                                    <div class="flex items-center space-x-6">
                                        {{-- Botó Editar --}}
                                        @can('update', $jugadora)
                                            <a href="{{ route('jugadores.edit', $jugadora) }}" class="text-yellow-600 hover:text-yellow-800 transition" title="Editar">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </a>
                                        @endcan

                                        {{-- Botó Eliminar --}}
                                        @can('delete', $jugadora)
                                            <form action="{{ route('jugadores.destroy', $jugadora) }}" method="POST" class="inline-block" onsubmit="return confirm('Segur que vols eliminar aquesta jugadora?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 transition" title="Eliminar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
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