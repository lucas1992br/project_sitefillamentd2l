@extends('layouts.site')

@section('title', __('site.services.title') . ' — ' . config('app.name'))
@section('description', __('site.services.description'))

@section('content')

    <section class="bg-slate-950 text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-tech-grid opacity-40 pointer-events-none"></div>
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-blue-500/40 to-transparent"></div>
        <div class="relative max-w-7xl mx-auto px-6">
            <p class="text-xs font-semibold tracking-widest text-blue-400 uppercase mb-3">{{ __('site.services.what_we_do') }}</p>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ __('site.services.title') }}</h1>
            <p class="text-blue-200/70 max-w-xl leading-relaxed">
                {{ __('site.services.description') }}
            </p>
        </div>
    </section>

    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($services as $service)
                    <div class="group bg-white rounded-2xl border border-slate-100 overflow-hidden card-glow transition-all duration-300 hover:-translate-y-1 hover:border-blue-200">
                        @php
                            $images = collect();
                            $cover = $service->getFirstMedia('cover');
                            if ($cover) {
                                $images->push([
                                    'thumb' => $cover->hasGeneratedConversion('card') ? $cover->getUrl('card') : $cover->getUrl(),
                                    'full'  => $cover->getUrl(),
                                    'alt'   => $service->title,
                                ]);
                            }
                            foreach ($service->getMedia('gallery') as $media) {
                                $images->push([
                                    'thumb' => $media->hasGeneratedConversion('card') ? $media->getUrl('card') : $media->getUrl(),
                                    'full'  => $media->getUrl(),
                                    'alt'   => $service->title,
                                ]);
                            }
                        @endphp

                        @if ($images->isNotEmpty())
                            <x-image-slider :images="$images" height="h-44" />
                        @else
                            <div class="w-full h-44 bg-slate-50 flex items-center justify-center border-b border-slate-100">
                                <x-icon name="wrench-screwdriver" class="w-10 h-10 text-slate-200" />
                            </div>
                        @endif

                        <div class="p-6">
                            <h2 class="text-base font-bold text-slate-900 mb-1 group-hover:text-blue-600 transition-colors">{{ $service->title }}</h2>

                            @if ($service->subtitle)
                                <p class="text-xs font-semibold text-blue-500 uppercase tracking-wider mb-3">{{ $service->subtitle }}</p>
                            @endif

                            <div class="text-sm text-slate-500 leading-relaxed prose prose-sm max-w-none">
                                {!! $service->description !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-16 bg-slate-900 text-white text-center relative overflow-hidden">
        <div class="absolute inset-0 bg-tech-grid opacity-30 pointer-events-none"></div>
        <div class="relative max-w-2xl mx-auto px-6">
            <h2 class="text-2xl md:text-3xl font-bold mb-3">Precisa de uma peça personalizada?</h2>
            <p class="text-slate-400 mb-8">Fale sobre seu projeto e retornaremos com um orçamento detalhado.</p>
            <a href="{{ route('contact') }}"
               class="inline-flex items-center gap-2 px-8 py-3 rounded-full bg-blue-500 text-white font-semibold text-sm hover:bg-blue-400 transition shadow-lg shadow-blue-500/30">
                <x-icon name="document-text" class="w-4 h-4" />
                Solicitar Orçamento
            </a>
        </div>
    </section>

@endsection
