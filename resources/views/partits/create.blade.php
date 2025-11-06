@extends('layouts.app')

@section('content')
<div class="vista-contingut">
    <h2>Crear Nou Partit</h2>

    <form action="{{ route('partits.store') }}" method="POST" class="formulari">
        @csrf

        <div class="form-group">
            <label for="local">Equip Local</label>
            <input type="text" id="local" name="local" value="{{ old('local') }}">
        </div>

        <div class="form-group">
            <label for="visitant">Equip Visitant</label>
            <input type="text" id="visitant" name="visitant" value="{{ old('visitant') }}">
        </div>

        <div class="form-group">
            <label for="data">Data</label>
            <input type="date" id="data" name="data" value="{{ old('data') }}">
        </div>

        <div class="form-group">
            <label for="resultat">Resultat (opcional, ex. 2-1)</label>
            <input type="text" id="resultat" name="resultat" value="{{ old('resultat') }}" placeholder="Ex. 3-0">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('partits.index') }}" class="btn btn-secondary">Cancel·lar</a>
        </div>
    </form>
</div>
@endsection