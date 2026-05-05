@extends('layouts.site')

@section('title', __('site.portfolio.title') . ' — ' . config('app.name'))
@section('description', __('site.portfolio.description'))

@section('content')

    <section class="bg-slate-950 text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-tech-grid opacity-40 pointer-events-none"></div>
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-blue-500/40 to-transparent"></div>
        <div class="relative max-w-7xl mx-auto px-6">
            <p class="text-xs font-semibold tracking-widest text-blue-400 uppercase mb-3">{{ __('site.portfolio.tag') }}</p>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ __('site.portfolio.title') }}</h1>
            <p class="text-blue-200/70 max-w-xl leading-relaxed">
                {{ __('site.portfolio.description') }}
            </p>
        </div>
    </section>

    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6">
            <livewire:portfolio-grid />
        </div>
    </section>

@endsection
