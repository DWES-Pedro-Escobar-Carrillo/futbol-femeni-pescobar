@extends('layouts.app')

@section('content')
<div class="vista-contingut">
    <h2>Crear Nou Estadi</h2>

    <form action="{{ route('estadis.store') }}" method="POST" class="formulari">
        @csrf

        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" value="{{ old('nom') }}">
        </div>

        <div class="form-group">
            <label for="ciutat">Ciutat</label>
            <input type="text" id="ciutat" name="ciutat" value="{{ old('ciutat') }}">
        </div>

        <div class="form-group">
            <label for="capacitat">Capacitat</label>
            <input type="number" id="capacitat" name="capacitat" value="{{ old('capacitat') }}" min="0">
        </div>

        <div class="form-group">
            <label for="equip_principal">Equip Principal</label>
            <input type="text" id="equip_principal" name="equip_principal" value="{{ old('equip_principal') }}">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('estadis.index') }}" class="btn btn-secondary">Cancel·lar</a>
        </div>
    </form>
</div>
@endsection