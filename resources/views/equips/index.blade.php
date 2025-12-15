<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Guia d'Equips") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                {{-- Missatges d'èxit/error --}}
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                {{-- Botó Crear: Només si té permís --}}
                @can('create', App\Models\Equip::class)
                    <p class="mb-4">
                        <a href="{{ route('equips.create') }}" class="bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700 transition">
                            + Nou equip
                        </a>
                    </p>
                @endcan

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-300">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border border-gray-300 p-2 text-left">Nom</th>
                                <th class="border border-gray-300 p-2 text-left">Estadi</th>
                                <th class="border border-gray-300 p-2 text-left">Títols</th>
                                <th class="border border-gray-300 p-2 text-left">Accions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($equips as $equip)
                            <tr class="hover:bg-gray-100 transition">
                                <td class="border border-gray-300 p-2">
                                    <a href="{{ route('equips.show', $equip) }}" class="text-blue-700 hover:underline font-bold">
                                        {{ $equip->nom }}
                                    </a>
                                </td>
                                <td class="border border-gray-300 p-2">
                                    @if ($equip->estadi)
                                        <a href="{{ route('estadis.show', $equip->estadi) }}" class="text-blue-700 hover:underline">
                                            {{ $equip->estadi->nom }}
                                        </a>
                                    @else
                                        <span class="text-gray-500 italic">Sense estadi</span>
                                    @endif
                                </td>
                                <td class="border border-gray-300 p-2">{{ $equip->titols }}</td>
                                <td class="border border-gray-300 p-2">
                                    {{-- Botons d'acció protegits --}}
                                    <div class="flex items-center space-x-3">
                                        @can('update', $equip)
                                            <a href="{{ route('equips.edit', $equip) }}" class="text-yellow-600 hover:text-yellow-800 font-medium hover:underline">
                                                Editar
                                            </a>
                                        @endcan

                                        @can('delete', $equip)
                                            <form action="{{ route('equips.destroy', $equip) }}" method="POST" class="inline-block" onsubmit="return confirm('Estàs segur que vols esborrar aquest equip?');">
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