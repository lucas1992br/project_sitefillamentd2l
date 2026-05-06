@extends('layouts.site')

@section('title', __('site.catalog.title') . ' — ' . config('app.name'))
@section('description', __('site.catalog.description'))

@section('content')

    {{-- Page header --}}
    <section class="py-16 bg-[#f9f9ff] border-b border-[#e1e2eb]">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <p class="text-xs font-bold tracking-widest text-[#0066cc] uppercase mb-3">{{ __('site.catalog.tag') }}</p>
            <h1 class="text-4xl md:text-5xl font-bold text-[#191c22] tracking-tight mb-4">{{ __('site.catalog.title') }}</h1>
            <p class="text-[#414753] max-w-xl leading-relaxed text-lg">{{ __('site.catalog.description') }}</p>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <livewire:catalog-grid />
        </div>
    </section>

@endsection
