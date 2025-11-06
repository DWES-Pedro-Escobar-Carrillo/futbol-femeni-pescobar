@extends('layouts.app')
@section('title', "Llistat d'Estadis")

@section('content')
<h1 class="text-3xl font-bold text-blue-800 mb-6">Llistat d'Estadis</h1>

@include('partials.messages')

<p class="mb-4">
    <a href="{{ route('estadis.create') }}" class="bg-blue-600 text-white px-3 py-2 rounded">+ Nou Estadi</a>
</p>

<table class="w-full border-collapse border border-gray-300">
    <thead class="bg-gray-200">
    <tr>
        <th class="border border-gray-300 p-2">Nom</th>
        <th class="border border-gray-300 p-2">Ciutat</th>
        <th class="border border-gray-300 p-2">Capacitat</th>
        <th class="border border-gray-300 p-2">Equip Principal</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($estadis as $key => $estadi)
        <tr class="hover:bg-gray-100">
            <td class="border border-gray-300 p-2">
                <a href="{{ route('estadis.show', $key) }}" class="text-blue-700 hover:underline">{{ $estadi['nom'] }}</a>
            </td>
            <td class="border border-gray-300 p-2">{{ $estadi['ciutat'] }}</td>
            <td class="border border-gray-300 p-2">{{ number_format($estadi['capacitat'], 0, ',', '.') }}</td>
            <td class="border border-gray-300 p-2">{{ $estadi['equip_principal'] }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="border border-gray-300 p-2">No hi ha estadis per mostrar.</td>
        </tr>
    @endforelse
    </tbody>
</table>
@endsection