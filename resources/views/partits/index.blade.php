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
                                        <div class="flex items-center justify-center space-x-6">
                                            @can('update', $partit)
                                                <a href="{{ route('partits.edit', $partit) }}" class="text-yellow-600 hover:text-yellow-800 transition" title="{{ Auth::user()->role === 'arbitre' ? 'Posar Resultat' : 'Editar' }}">
                                                    @if(Auth::user()->role === 'arbitre')
                                                        {{-- Icono Clipboard para Árbitro --}}
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                          <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                                                        </svg>
                                                    @else
                                                        {{-- Icono Lápiz Normal --}}
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                        </svg>
                                                    @endif
                                                </a>
                                            @endcan

                                            @can('delete', $partit)
                                                <form action="{{ route('partits.destroy', $partit) }}" method="POST" class="inline-block" onsubmit="return confirm('Estàs segur?');">
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