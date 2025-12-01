@props(['nom', 'capacitat', 'equips'])

<div class="border rounded-lg shadow-md p-6 bg-white">
    <h1 class="text-3xl font-bold text-blue-800 mb-4">{{ $nom }}</h1>
    <p class="text-lg text-gray-700"><strong>Capacitat:</strong> {{ number_format($capacitat, 0, ',', '.') }} espectadors</p>
</div>