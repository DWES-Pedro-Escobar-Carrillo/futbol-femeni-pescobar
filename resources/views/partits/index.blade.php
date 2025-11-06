@extends('layouts.app')

@section('content')
<div class="vista-contingut">
    <div class="capcalera-vista">
        <h2>Llistat de Partits</h2>
        <a href="{{ route('partits.create') }}" class="btn btn-primary">+ Nou Partit</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Local</th>
                <th>Visitant</th>
                <th>Data</th>
                <th>Resultat</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($partits as $partit)
                <tr>
                    <td><x-equip-mini :nom="$partit['local']" /></td>
                    <td><x-equip-mini :nom="$partit['visitant']" /></td>
                    <td>{{ \Carbon\Carbon::parse($partit['data'])->format('d/m/Y') }}</td>
                    <td>{{ $partit['resultat'] ?? 'Pendent' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No hi ha partits per mostrar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection