<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="tallstackui_darkTheme()">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <tallstackui:script />
        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased"
          x-cloak
          x-data="{ name: @js(auth()->user()->name) }"
          x-on:name-updated.window="name = $event.detail.name"
          x-bind:class="{ 'dark bg-gray-800': darkTheme, 'bg-gray-100': !darkTheme }">
    <x-layout>
        <x-slot:top>
            <x-dialog />
            <x-toast />
        </x-slot:top>
        <x-slot:header>
            <x-layout.header>
                <x-slot:right>
                    <x-dropdown>
                        <x-slot:action>
                            <div>
                                <button class="cursor-pointer" x-on:click="show = !show">
                                    <span class="text-base font-semibold text-primary-500" x-text="name"></span>
                                </button>
                            </div>
                        </x-slot:action>
                        <x-slot:header>
                            <x-theme-switch block />
                        </x-slot:header>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown.items :text="__('Profile')" :href="route('user.profile')" />
                            <x-dropdown.items :text="__('Logout')" onclick="event.preventDefault(); this.closest('form').submit();" separator />
                        </form>
                    </x-dropdown>
                </x-slot:right>
            </x-layout.header>
        </x-slot:header>
        @php
            $siteContent   = App\Models\SiteContent::instance();
            $logoAdminUrl  = $siteContent->getFirstMediaUrl('logo_admin') ?: $siteContent->getFirstMediaUrl('logo');
        @endphp
        <x-slot:menu>
            <x-side-bar smart collapsible>
                <x-slot:brand>
                    <div class="px-4 py-3 flex items-center justify-center border-b border-white/10">
                        @if($logoAdminUrl)
                            <img src="{{ $logoAdminUrl }}" alt="{{ config('app.name') }}"
                                 class="h-10 w-auto max-w-[140px] object-contain" />
                        @else
                            <span class="text-sm font-bold text-white truncate">{{ config('app.name') }}</span>
                        @endif
                    </div>
                </x-slot:brand>
                <x-slot:brand-collapsed>
                    <div class="px-2 py-3 flex items-center justify-center border-b border-white/10">
                        @if($logoAdminUrl)
                            <img src="{{ $logoAdminUrl }}" alt="{{ config('app.name') }}"
                                 class="h-8 w-8 object-contain" />
                        @else
                            <span class="text-xs font-bold text-white">{{ substr(config('app.name'), 0, 1) }}</span>
                        @endif
                    </div>
                </x-slot:brand-collapsed>
                <x-side-bar.item text="Dashboard" icon="home" :route="route('dashboard')" />
                <x-side-bar.item text="Users" icon="users" :route="route('users.index')" />
                <x-side-bar.item text="Welcome Page" icon="arrow-uturn-left" :route="route('welcome')" />
            </x-side-bar>
        </x-slot:menu>
        {{ $slot }}
    </x-layout>
    @livewireScripts
    </body>
</html>
