@extends('layouts.app')

@section('content')
<div class="vista-contingut">
    <div class="capcalera-vista">
        <h2>Llistat de Jugadores</h2>
        <a href="{{ route('jugadores.create') }}" class="btn btn-primary">+ Nova Jugadora</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Equip</th>
                <th>Posició</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($jugadores as $jugadora)
                <x-jugadora :jugadora="$jugadora" />
            @empty
                <tr>
                    <td colspan="3">No hi ha jugadores per mostrar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection