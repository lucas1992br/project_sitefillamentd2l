@extends('layouts.site')

@section('title', 'Portfolio — ' . config('app.name'))
@section('description', 'Browse our portfolio of precision CNC machined parts and industrial projects.')

@section('content')

    <section class="bg-blue-950 text-white py-16">
        <div class="max-w-7xl mx-auto px-6">
            <p class="text-xs font-medium tracking-widest text-blue-300 uppercase mb-3">Our Work</p>
            <h1 class="text-4xl font-bold mb-4">Portfolio</h1>
            <p class="text-blue-200 max-w-xl leading-relaxed">
                A selection of completed projects across industries and materials.
            </p>
        </div>
    </section>

    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <livewire:portfolio-grid />
        </div>
    </section>

@endsection
