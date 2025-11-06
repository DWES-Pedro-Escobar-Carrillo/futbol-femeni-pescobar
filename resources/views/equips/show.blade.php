@extends('layouts.app')
@section('title', "Detall d'Equip")

@section('content')
<x-equip :nom="$equip['nom']" :estadi="$equip['estadi']" :titols="$equip['titols']"/>

<p class="mt-4">
    <a href="{{ route('estadis.index') }}" class="bg-gray-300 text-black px-4 py-2 rounded">Tornar al llistat</a>
</p>
@endsection