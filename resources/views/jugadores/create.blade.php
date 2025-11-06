@extends('layouts.app')

@section('content')
<div class="vista-contingut">
    <h2>Crear Nova Jugadora</h2>

    <form action="{{ route('jugadores.store') }}" method="POST" class="formulari">
        @csrf

        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" value="{{ old('nom') }}">
        </div>

        <div class="form-group">
            <label for="equip">Equip</label>
            <input type="text" id="equip" name="equip" value="{{ old('equip') }}">
        </div>

        <div class="form-group">
            <label for="posicio">Posició</label>
            <select id="posicio" name="posicio">
                <option value="">Selecciona una posició</option>
                @foreach ($posicions as $posicio)
                    <option value="{{ $posicio }}" {{ old('posicio') == $posicio ? 'selected' : '' }}>
                        {{ $posicio }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('jugadores.index') }}" class="btn btn-secondary">Cancel·lar</a>
        </div>
    </form>
</div>
@endsection