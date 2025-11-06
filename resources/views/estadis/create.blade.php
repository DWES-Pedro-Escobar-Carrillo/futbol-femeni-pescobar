@extends('layouts.app')
@section('title', 'Crear Nou Estadi')

@section('content')
<h1 class="text-2xl font-bold mb-4">Crear Nou Estadi</h1>

@include('partials.messages')

<form action="{{ route('estadis.store') }}" method="POST" class="space-y-4">
    @csrf
    <div>
        <label for="nom" class="block font-bold">Nom:</label>
        <input type="text" id="nom" name="nom" value="{{ old('nom') }}" class="border p-2 w-full">
    </div>

    <div>
        <label for="ciutat" class="block font-bold">Ciutat:</label>
        <input type="text" id="ciutat" name="ciutat" value="{{ old('ciutat') }}" class="border p-2 w-full">
    </div>

    <div>
        <label for="capacitat" class="block font-bold">Capacitat:</label>
        <input type="number" id="capacitat" name="capacitat" value="{{ old('capacitat') }}" min="0" class="border p-2 w-full">
    </div>

    <div>
        <label for="equip_principal" class="block font-bold">Equip Principal:</label>
        <input type="text" id="equip_principal" name="equip_principal" value="{{ old('equip_principal') }}" class="border p-2 w-full">
    </div>

    <div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
        <a href="{{ route('estadis.index') }}" class="bg-gray-300 text-black px-4 py-2 rounded">Cancel·lar</a>
    </div>
</form>
@endsection