@extends('layouts.app')
@section('title', "Detall de l'Estadi")

@section('content')
<div class="border rounded-lg shadow-md p-4 bg-white">
    <h1 class="text-3xl font-bold text-blue-800 mb-6">{{ $estadi['nom'] }}</h1>
    <p><strong>Ciutat:</strong> {{ $estadi['ciutat'] }}</p>
    <p><strong>Capacitat:</strong> {{ number_format($estadi['capacitat'], 0, ',', '.') }}</p>
    <p><strong>Equip Principal:</strong> {{ $estadi['equip_principal'] }}</p>
</div>

<p class="mt-4">
    <a href="{{ route('estadis.index') }}" class="bg-gray-300 text-black px-4 py-2 rounded">Tornar al llistat</a>
</p>
@endsection