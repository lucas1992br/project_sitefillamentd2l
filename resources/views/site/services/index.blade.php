@extends('layouts.site')

@section('title', __('site.services.title') . ' — ' . config('app.name'))
@section('description', __('site.services.description'))

@section('content')

    {{-- Page header --}}
    <section class="py-16 bg-[#f9f9ff] border-b border-[#e1e2eb]">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <p class="text-xs font-bold tracking-widest text-[#0066cc] uppercase mb-3">{{ __('site.services.what_we_do') }}</p>
            <h1 class="text-4xl md:text-5xl font-bold text-[#191c22] tracking-tight mb-4">{{ __('site.services.title') }}</h1>
            <p class="text-[#414753] max-w-xl leading-relaxed text-lg">{{ __('site.services.description') }}</p>
        </div>
    </section>

    {{-- Cards --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($services as $service)
                    <div class="group bg-white rounded-xl border border-[#e1e2eb] overflow-hidden il-card-hover transition-all duration-300 hover:-translate-y-1">
                        @php
                            $images = collect();
                            $cover = $service->getFirstMedia('cover');
                            if ($cover) {
                                $images->push([
                                    'thumb' => $cover->hasGeneratedConversion('card') ? $cover->getUrl('card') : $cover->getUrl(),
                                    'full'  => $cover->getUrl(),
                                    'alt'   => td($service->title),
                                ]);
                            }
                            foreach ($service->getMedia('gallery') as $media) {
                                $images->push([
                                    'thumb' => $media->hasGeneratedConversion('card') ? $media->getUrl('card') : $media->getUrl(),
                                    'full'  => $media->getUrl(),
                                    'alt'   => td($service->title),
                                ]);
                            }
                        @endphp

                        @if ($images->isNotEmpty())
                            <x-image-slider :images="$images" height="h-44" />
                        @else
                            <div class="w-full h-44 bg-[#ecedf6] flex items-center justify-center">
                                <x-icon name="wrench-screwdriver" class="w-10 h-10 text-[#c1c6d5]" />
                            </div>
                        @endif

                        <div class="p-6">
                            <div class="w-10 h-10 rounded-lg bg-[#d7e3ff] flex items-center justify-center mb-3 group-hover:bg-[#0066cc] transition-colors">
                                <x-icon name="{{ $service->icon ?? 'cog-6-tooth' }}" class="w-5 h-5 text-[#0066cc] group-hover:text-white transition-colors" />
                            </div>
                            <h2 class="text-base font-bold text-[#191c22] mb-1 group-hover:text-[#0066cc] transition-colors">{{ td($service->title) }}</h2>

                            @if ($service->subtitle)
                                <p class="text-xs font-semibold text-[#727784] uppercase tracking-wider mb-3">{{ td($service->subtitle) }}</p>
                            @endif

                            <div class="text-sm text-[#414753] leading-relaxed prose prose-sm max-w-none">
                                {!! td($service->description) !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-16 bg-[#004e9f] text-center relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 rounded-full bg-white/5 blur-3xl pointer-events-none"></div>
        <div class="relative max-w-2xl mx-auto px-6">
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-3">{{ __('site.home.cta_quote') }}</h2>
            <p class="text-[#aac7ff] mb-8">{{ __('site.contact.subheading') }}</p>
            <a href="{{ route('contact') }}"
               class="inline-flex items-center gap-2 px-8 py-3.5 rounded-lg bg-white text-[#004e9f] font-bold text-sm hover:bg-[#d7e3ff] transition shadow-lg">
                <x-icon name="document-text" class="w-4 h-4" />
                {{ __('site.home.cta_quote') }}
            </a>
        </div>
    </section>

@endsection
