@extends('layouts.site')

@section('title', 'Services — ' . config('app.name'))
@section('description', 'Full-range industrial CNC machining services: turning, milling, welding and surface finishing.')

@section('content')

    <section class="bg-blue-950 text-white py-16">
        <div class="max-w-7xl mx-auto px-6">
            <p class="text-xs font-medium tracking-widest text-blue-300 uppercase mb-3">What We Do</p>
            <h1 class="text-4xl font-bold mb-4">Our Services</h1>
            <p class="text-blue-200 max-w-xl leading-relaxed">
                Complete industrial capability — from raw material to finished part.
            </p>
        </div>
    </section>

    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($services as $service)
                    <x-card class="border border-blue-100 border-t-4 border-t-blue-500 hover:shadow-md transition">
                        @if ($service->getFirstMedia('cover'))
                            <img src="{{ $service->getFirstMediaUrl('cover', 'card') }}"
                                 alt="{{ $service->title }}"
                                 class="w-full h-44 object-cover rounded-lg mb-4">
                        @endif

                        <h2 class="text-base font-semibold text-blue-900 mb-1">{{ $service->title }}</h2>

                        @if ($service->subtitle)
                            <x-badge color="primary" :text="$service->subtitle" class="mb-3" />
                        @endif

                        <div class="text-sm text-gray-500 leading-relaxed prose prose-sm max-w-none">
                            {!! $service->description !!}
                        </div>
                    </x-card>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-16 bg-blue-900 text-white text-center">
        <div class="max-w-2xl mx-auto px-6">
            <h2 class="text-2xl font-bold mb-3">Need a custom part?</h2>
            <p class="text-blue-200 mb-8">Tell us about your project and we'll get back with a quote.</p>
            <x-button
                href="{{ route('contact') }}"
                color="white"
                text="Request a Quote"
                class="rounded-full px-10"
            />
        </div>
    </section>

@endsection
