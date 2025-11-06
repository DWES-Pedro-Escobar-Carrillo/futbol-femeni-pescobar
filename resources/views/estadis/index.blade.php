@extends('layouts.app')

@section('content')
<div class="vista-contingut">
    <div class="capcalera-vista">
        <h2>Llistat d'Estadis</h2>
        <a href="{{ route('estadis.create') }}" class="btn btn-primary">+ Nou Estadi</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Ciutat</th>
                <th>Capacitat</th>
                <th>Equip Principal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($estadis as $estadi)
                {{-- Utilitzem el component Blade per a la fila --}}
                <x-estadi :estadi="$estadi" />
            @empty
                <tr>
                    <td colspan="4">No hi ha estadis per mostrar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection