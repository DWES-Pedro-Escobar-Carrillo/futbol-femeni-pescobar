@props(['equip'])

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border flex flex-col items-center h-full">
    {{-- Escut --}}
    @if($equip->escut)
        <img src="{{ asset('storage/' . $equip->escut) }}" alt="Escut de {{ $equip->nom }}" class="h-24 w-24 object-contain mb-4">
    @else
        <div class="h-24 w-24 bg-gray-200 rounded-full mb-4 flex items-center justify-center text-gray-500 text-xs text-center p-2">
            Sense escut
        </div>
    @endif
  
    {{-- Informació --}}
    <div class="text-center mt-auto">
        <h2 class="text-xl font-bold text-blue-800 mb-2">{{ $equip->nom }}</h2>
        
        <p class="text-gray-700 text-sm mb-1">
            <strong>Estadi:</strong> {{ $equip->estadi->nom ?? 'Sense estadi' }}
        </p>
        
        <p class="text-gray-700 text-sm">
            <strong>Títols:</strong> {{ $equip->titols }}
        </p>
    </div>
</div>