<div>
    <div class="flex space-x-4 mb-4 items-center">
        <input 
            wire:model="equip" 
            type="text" 
            placeholder="Cerca equip" 
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-4 py-2"
        >

        <input 
            wire:model="data" 
            type="date" 
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-4 py-2"
        >

        <button 
            wire:click="filtrar" 
            class="bg-blue-500 hover:bg-blue-700 text-black font-bold p-2 rounded-md shadow-sm transition ease-in-out duration-150"
            title="Cercar"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
        </button>
    </div>

    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th class="py-3 px-6">Data</th>
                <th class="py-3 px-6">Local</th>
                <th class="py-3 px-6">Visitant</th>
                <th class="py-3 px-6">Resultat</th>
                <th class="py-3 px-6">Estadi</th>
                <th class="py-3 px-6">Àrbitre</th>
            </tr>
            </thead>
            <tbody>
            @forelse($partits as $partit)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="py-4 px-6">{{ $partit->data->format('d/m/Y H:i') }}</td>
                    <td class="py-4 px-6 font-medium text-gray-900">{{ $partit->equipLocal->nom ?? 'N/A' }}</td>
                    <td class="py-4 px-6 font-medium text-gray-900">{{ $partit->equipVisitant->nom ?? 'N/A' }}</td>
                    <td class="py-4 px-6">{{ $partit->resultat }}</td>
                    <td class="py-4 px-6">{{ $partit->estadi->nom ?? 'N/A' }}</td>
                    <td class="py-4 px-6">{{ $partit->arbitre->name ?? 'Sense assignar' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="py-4 px-6 text-center text-gray-500">
                        No s'han trobat partits amb aquests criteris.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>