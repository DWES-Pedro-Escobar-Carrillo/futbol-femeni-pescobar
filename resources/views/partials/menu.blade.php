@php
    $responsive = $responsive ?? false;
@endphp

@if(!$responsive)
    <x-nav-link :href="route('equips.index')" :active="request()->routeIs('equips.*')">
        {{ __('Equips') }}
    </x-nav-link>
    <x-nav-link :href="route('partits.index')" :active="request()->routeIs('partits.*')">
        {{ __('Partits') }}
    </x-nav-link>
    <x-nav-link :href="route('jugadores.index')" :active="request()->routeIs('jugadores.*')">
        {{ __('Jugadores') }}
    </x-nav-link>
    <x-nav-link :href="route('estadis.index')" :active="request()->routeIs('estadis.*')">
        {{ __('Estadis') }}
    </x-nav-link>
@else
    <x-responsive-nav-link :href="route('equips.index')" :active="request()->routeIs('equips.*')">
        {{ __('Equips') }}
    </x-responsive-nav-link>
    <x-responsive-nav-link :href="route('partits.index')" :active="request()->routeIs('partits.*')">
        {{ __('Partits') }}
    </x-responsive-nav-link>
    <x-responsive-nav-link :href="route('jugadores.index')" :active="request()->routeIs('jugadores.*')">
        {{ __('Jugadores') }}
    </x-responsive-nav-link>
    <x-responsive-nav-link :href="route('estadis.index')" :active="request()->routeIs('estadis.*')">
        {{ __('Estadis') }}
    </x-responsive-nav-link>
@endif