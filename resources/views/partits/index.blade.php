<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Llistat de Partits") }}
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

                {{-- Només Admin pot crear partits --}}
                @can('create', App\Models\Partit::class)
                    <p class="mb-4">
                        <a href="{{ route('partits.create') }}" class="bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700 transition">
                            + Nou Partit
                        </a>
                    </p>
                @endcan

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-300">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border border-gray-300 p-2">Data</th>
                                <th class="border border-gray-300 p-2">Local</th>
                                <th class="border border-gray-300 p-2">Visitant</th>
                                <th class="border border-gray-300 p-2">Resultat</th>
                                <th class="border border-gray-300 p-2">Accions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($partits as $partit)
                                <tr class="hover:bg-gray-100 transition">
                                    {{-- Data --}}
                                    <td class="border border-gray-300 p-2">
                                        {{ \Carbon\Carbon::parse($partit->data_partit)->format('d/m/Y') }}
                                    </td>
                                    
                                    {{-- Local --}}
                                    <td class="border border-gray-300 p-2 font-medium">
                                        @if ($partit->equipLocal)
                                            <a href="{{ route('equips.show', $partit->equipLocal) }}" class="text-blue-700 hover:underline">
                                                {{ $partit->equipLocal->nom }}
                                            </a>
                                        @else
                                            <span class="text-gray-500">Desconegut</span>
                                        @endif
                                    </td>

                                    {{-- Visitant --}}
                                    <td class="border border-gray-300 p-2 font-medium">
                                        @if ($partit->equipVisitant)
                                            <a href="{{ route('equips.show', $partit->equipVisitant) }}" class="text-blue-700 hover:underline">
                                                {{ $partit->equipVisitant->nom }}
                                            </a>
                                        @else
                                            <span class="text-gray-500">Desconegut</span>
                                        @endif
                                    </td>

                                    {{-- Resultat --}}
                                    <td class="border border-gray-300 p-2 font-bold text-center bg-gray-50">
                                        <a href="{{ route('partits.show', $partit) }}" class="text-blue-700 hover:underline">
                                            {{ $partit->gols_local }} - {{ $partit->gols_visitant }}
                                        </a>
                                    </td>

                                    {{-- Accions --}}
                                    <td class="border border-gray-300 p-2">
                                        <div class="flex items-center space-x-3 justify-center">
                                            @can('update', $partit)
                                                <a href="{{ route('partits.edit', $partit) }}" class="text-yellow-600 hover:text-yellow-800 font-medium hover:underline">
                                                    {{-- Canviem el text segons si és àrbitre o admin --}}
                                                    {{ Auth::user()->role === 'arbitre' ? 'Posar Resultat' : 'Editar' }}
                                                </a>
                                            @endcan

                                            @can('delete', $partit)
                                                <form action="{{ route('partits.destroy', $partit) }}" method="POST" class="inline-block" onsubmit="return confirm('Estàs segur?');">
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
                            @empty
                                <tr>
                                    <td colspan="5" class="border border-gray-300 p-4 text-center text-gray-500">
                                        No hi ha partits per mostrar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>