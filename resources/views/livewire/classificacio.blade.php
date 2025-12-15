<div wire:poll.5s>
    <div class="overflow-x-auto">
        <h3 class="text-lg font-bold mb-4 text-gray-800">Classificació en Temps Real</h3>
        
        <table class="w-full text-sm text-left text-gray-500 border rounded-lg overflow-hidden shadow-sm">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                <tr>
                    <th class="px-4 py-3">Pos</th>
                    <th class="px-4 py-3">Equip</th>
                    <th class="px-4 py-3 font-bold text-black">Pts</th>
                    <th class="px-4 py-3">PJ</th>
                    <th class="px-4 py-3 hidden sm:table-cell">PG</th>
                    <th class="px-4 py-3 hidden sm:table-cell">PE</th>
                    <th class="px-4 py-3 hidden sm:table-cell">PP</th>
                    <th class="px-4 py-3 hidden md:table-cell">GF</th>
                    <th class="px-4 py-3 hidden md:table-cell">GC</th>
                    <th class="px-4 py-3">DG</th>
                </tr>
            </thead>
            <tbody>
                @foreach($taula as $equip)
                    <tr class="bg-white border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-3 font-medium">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 flex items-center">
                            @if($equip['escut'])
                                <img src="{{ asset('storage/' . $equip['escut']) }}" class="w-6 h-6 mr-2 object-contain">
                            @endif
                            <span class="font-bold text-gray-900">{{ $equip['nom'] }}</span>
                        </td>
                        <td class="px-4 py-3 font-black text-blue-600 text-base">{{ $equip['punts'] }}</td>
                        <td class="px-4 py-3">{{ $equip['jugats'] }}</td>
                        <td class="px-4 py-3 hidden sm:table-cell text-green-600">{{ $equip['guanyats'] }}</td>
                        <td class="px-4 py-3 hidden sm:table-cell text-yellow-600">{{ $equip['empatats'] }}</td>
                        <td class="px-4 py-3 hidden sm:table-cell text-red-600">{{ $equip['perduts'] }}</td>
                        <td class="px-4 py-3 hidden md:table-cell">{{ $equip['gf'] }}</td>
                        <td class="px-4 py-3 hidden md:table-cell">{{ $equip['gc'] }}</td>
                        <td class="px-4 py-3 font-bold">{{ $equip['dg'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <p class="text-xs text-gray-400 mt-2 text-right">
            S'actualitza automàticament cada 5 segons.
        </p>
    </div>
</div>