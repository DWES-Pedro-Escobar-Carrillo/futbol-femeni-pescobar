@props(['nom', 'estadi', 'titols', 'escut' => null])

<div class="equip border rounded-lg shadow-md p-4 bg-white flex items-center gap-4">
    @if($escut)
        {{-- Hem canviat a w-16 h-16 per fer-lo més petit (aprox 64px) --}}
        <img src="{{ Storage::url($escut) }}" alt="Escut de {{ $nom }}" class="w-16 h-16 object-contain">
    @else
        {{-- Placeholder també petit --}}
        <div class="w-16 h-16 bg-gray-200 flex items-center justify-center text-gray-500 rounded-full text-xs text-center p-1">
            Sense escut
        </div>
    @endif
  
    <div>
        <h2 class="text-xl font-bold text-blue-800">{{ $nom }}</h2>
        <p><strong>Estadi:</strong> {{ $estadi }}</p>
        <p><strong>Títols:</strong> {{ $titols }}</p>
    </div>
</div>