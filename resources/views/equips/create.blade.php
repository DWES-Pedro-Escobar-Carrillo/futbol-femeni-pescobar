@extends('layouts.equip')
@section('title', __("Creació d'Equips"))

@section('content')
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error) 
                    <li>• {{ $error }}</li> 
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('equips.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        
        <div>
            <x-input-label for="nom" :value="__('Nom')" />
            <x-text-input id="nom" name="nom" type="text" class="mt-1 block w-full" :value="old('nom')" required />
        </div>

        <div>
            <x-input-label for="estadi_id" :value="__('Estadi')" />
            <select name="estadi_id" id="estadi_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full">
                @foreach ($estadis as $estadi)
                    <option value="{{ $estadi->id }}" {{ old('estadi_id') == $estadi->id ? 'selected' : '' }}>
                        {{ $estadi->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <x-input-label for="titols" :value="__('Títols')" />
            <x-text-input id="titols" name="titols" type="number" class="mt-1 block w-full" :value="old('titols')" required />
        </div>

        <div class="mb-4">
            <x-input-label for="escut" :value="__('Escut')" />
            <input type="file" name="escut" id="escut" class="mt-1 block w-full text-sm text-gray-500
                file:mr-4 file:py-2 file:px-4
                file:rounded-full file:border-0
                file:text-sm file:font-semibold
                file:bg-blue-50 file:text-blue-700
                hover:file:bg-blue-100">
        </div>

        <x-primary-button>
            {{ __('Crear Equip') }}
        </x-primary-button>
    </form>
@endsection