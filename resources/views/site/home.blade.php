@extends('layouts.site')

@section('title', 'D2L — Soluções em Metálicas')
@section('description', '')

@section('content')

{{-- ══════════════════════════════════════════════════
     1. HERO
══════════════════════════════════════════════════ --}}
<section class="relative flex items-center overflow-hidden bg-white min-h-[90vh]">

    {{-- Background: vídeo ou imagem de fundo --}}
    @if($siteContent->showcase_video_active && $siteContent->getFirstMedia('showcase_video'))
        <video autoplay muted loop playsinline
               class="absolute inset-0 w-full h-full object-cover">
            <source src="{{ $siteContent->getFirstMediaUrl('showcase_video') }}" type="video/mp4">
        </video>
        <div class="absolute inset-0 bg-white/75"></div>
    @else
        <div class="absolute inset-0"
             style="background: linear-gradient(135deg, #f9f9ff 0%, #e6e8f1 60%, #d7e3ff 100%);">
        </div>
        <div class="absolute inset-0 bg-tech-grid-light opacity-10"></div>
    @endif

    <div class="absolute right-0 top-1/4 w-[520px] h-[520px] rounded-full pointer-events-none"
         style="background: radial-gradient(circle, rgba(0,102,204,0.08) 0%, transparent 70%);"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 md:px-12 w-full py-28 md:py-36">
        <div class="max-w-3xl">

            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-[#0066cc]/30 bg-[#d7e3ff]/60 mb-8">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#0066cc] opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-[#0066cc]"></span>
                </span>
                <span class="text-xs font-bold text-[#004e9f] tracking-widest uppercase">{{ __('site.home.iso_badge') }}</span>
            </div>

            <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold leading-[1.1] tracking-tight text-[#191c22] mb-6">
                {{ __('site.home.headline1') }}<br>
                <span style="color:#0066cc">{{ __('site.home.headline2') }}</span>
            </h1>

            <p class="text-lg md:text-xl text-[#414753] leading-relaxed max-w-xl mb-10">
                {{ __('site.home.subtext') }}
            </p>

            <div class="flex flex-wrap gap-4">
                <a href="#contact"
                   class="inline-flex items-center gap-2 px-7 py-3.5 rounded-lg bg-[#0066cc] text-white font-bold text-sm hover:bg-[#004e9f] transition-all shadow-lg shadow-[#0066cc]/25">
                    <x-icon name="document-text" class="w-4 h-4" />
                    {{ __('site.home.cta_quote') }}
                </a>
                <a href="#portfolio"
                   class="inline-flex items-center gap-2 px-7 py-3.5 rounded-lg border border-[#c1c6d5] text-[#414753] font-bold text-sm hover:border-[#0066cc] hover:text-[#0066cc] transition-all bg-white">
                    <x-icon name="photo" class="w-4 h-4" />
                    {{ __('site.home.cta_portfolio') }}
                </a>
            </div>

            @if($siteContent->whatsapp_url || $siteContent->linkedin_url || $siteContent->instagram_url)
                <div class="flex items-center gap-3 mt-8">
                    <span class="text-xs text-[#727784] uppercase tracking-widest">{{ __('site.nav.follow_us') }}</span>
                    <div class="h-px w-6 bg-[#c1c6d5]"></div>
                    @if($siteContent->whatsapp_url)
                        <a href="{{ $siteContent->whatsapp_url }}" target="_blank" rel="noopener noreferrer"
                           class="w-9 h-9 rounded-full bg-white border border-[#c1c6d5] hover:border-[#25D366] hover:bg-[#25D366]/10 flex items-center justify-center transition-all">
                            <svg class="w-4 h-4 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                    @endif
                    @if($siteContent->linkedin_url)
                        <a href="{{ $siteContent->linkedin_url }}" target="_blank" rel="noopener noreferrer"
                           class="w-9 h-9 rounded-full bg-white border border-[#c1c6d5] hover:border-[#0A66C2] hover:bg-[#0A66C2]/10 flex items-center justify-center transition-all">
                            <svg class="w-4 h-4 text-[#0A66C2]" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                    @endif
                    @if($siteContent->instagram_url)
                        <a href="{{ $siteContent->instagram_url }}" target="_blank" rel="noopener noreferrer"
                           class="w-9 h-9 rounded-full bg-white border border-[#c1c6d5] hover:border-pink-500 hover:bg-pink-50 flex items-center justify-center transition-all">
                            <svg class="w-4 h-4 text-pink-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════════════
     2. QUEM SOMOS
══════════════════════════════════════════════════ --}}
@if($siteContent->about_active)
<section
    id="quem-somos"
    class="py-24 bg-[#f9f9ff] border-t border-[#e1e2eb] transition-all duration-700 ease-out"
    x-data="{ shown: false }"
    x-init="new IntersectionObserver(([e]) => { if (e.isIntersecting) { shown = true } }, { threshold: 0.1 }).observe($el)"
    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
>
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            <div>
                <p class="text-xs font-bold tracking-widest text-[#0066cc] uppercase mb-3">{{ __('site.home.about_tag') }}</p>
                <h2 class="text-4xl font-bold text-[#191c22] mb-6 leading-tight tracking-tight">
                    {{ $siteContent->about_title }}
                </h2>

                @if($siteContent->about_description)
                    <div class="space-y-4 text-[#414753] leading-relaxed text-base">
                        @foreach(explode("\n", $siteContent->about_description) as $paragraph)
                            @if(trim($paragraph))
                                <p>{{ trim($paragraph) }}</p>
                            @endif
                        @endforeach
                    </div>
                @endif

                @if($siteContent->about_founded_year)
                    <div class="mt-8 inline-flex items-center gap-3 px-5 py-3 rounded-full border border-[#aac7ff] bg-[#d7e3ff]/50">
                        <span class="w-2 h-2 rounded-full bg-[#0066cc]"></span>
                        <span class="text-sm font-bold text-[#004e9f]">
                            {{ __('site.home.about_founded', ['year' => $siteContent->about_founded_year, 'years' => (int) date('Y') - $siteContent->about_founded_year]) }}
                        </span>
                    </div>
                @endif
            </div>

            <div class="relative">
                @if($siteContent->getFirstMedia('about_image'))
                    <div class="rounded-2xl overflow-hidden shadow-xl border border-[#e1e2eb]">
                        <img src="{{ $siteContent->getFirstMediaUrl('about_image') }}"
                             alt="{{ $siteContent->about_title }}"
                             class="w-full h-80 lg:h-96 object-cover">
                    </div>
                @else
                    <div class="rounded-2xl bg-[#ecedf6] h-80 lg:h-96 flex flex-col items-center justify-center gap-6 border border-[#e1e2eb]">
                        <div class="w-16 h-16 rounded-2xl bg-[#d7e3ff] flex items-center justify-center">
                            <x-icon name="building-office-2" class="w-8 h-8 text-[#0066cc]" />
                        </div>
                        <p class="text-[#727784] text-sm">
                            <a href="{{ url('/admin') }}" class="text-[#0066cc] hover:underline">Admin → Conteúdo do Site</a>
                        </p>
                    </div>
                @endif
                <div class="absolute -bottom-4 -right-4 w-24 h-24 rounded-2xl bg-[#d7e3ff] border border-[#aac7ff] -z-10"></div>
                <div class="absolute -top-4 -left-4 w-16 h-16 rounded-xl bg-[#f2f3fc] border border-[#e1e2eb] -z-10"></div>
            </div>
        </div>
    </div>
</section>
@endif


{{-- ══════════════════════════════════════════════════
     3. CERTIFICAÇÕES
══════════════════════════════════════════════════ --}}
@if($certifications->isNotEmpty())
<section
    id="certifications"
    class="py-24 bg-white border-t border-[#e1e2eb] transition-all duration-700 ease-out"
    x-data="{ shown: false }"
    x-init="new IntersectionObserver(([e]) => { if (e.isIntersecting) { shown = true } }, { threshold: 0.08 }).observe($el)"
    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
>
    <div class="max-w-7xl mx-auto px-6 md:px-12">

        <div class="text-center mb-12">
            <p class="text-xs font-bold tracking-widest text-[#0066cc] uppercase mb-3">{{ __('site.home.certifications_tag') }}</p>
            <h2 class="text-4xl font-bold text-[#191c22] tracking-tight mb-4">{{ __('site.home.certifications_title') }}</h2>
            @if(__('site.home.certifications_subtitle'))
                <p class="text-[#414753] max-w-2xl mx-auto text-lg leading-relaxed">
                    {{ __('site.home.certifications_subtitle') }}
                </p>
            @endif
        </div>

        <div
            x-data="{ open: false, cert: {}, show(c) { this.cert = c; this.open = true; } }"
            @keydown.escape.window="open = false"
        >
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-10">
                @foreach($certifications as $cert)
                    @php
                        $certData = [
                            'name'               => td($cert->name),
                            'issuer'             => $cert->issuer,
                            'certificate_number' => $cert->certificate_number,
                            'issued_at'          => $cert->issued_at?->format('d/m/Y'),
                            'expires_at'         => $cert->expires_at?->format('d/m/Y'),
                            'description'        => td($cert->description),
                            'is_expired'         => $cert->isExpired(),
                            'logo_url'           => $cert->getFirstMediaUrl('logo'),
                            'cert_url'           => $cert->getFirstMediaUrl('certificate'),
                            'cert_mime'          => $cert->getFirstMedia('certificate')?->mime_type,
                        ];
                    @endphp
                    <button
                        type="button"
                        @click="show({{ json_encode($certData) }})"
                        class="group flex flex-col items-center justify-center p-6 bg-[#f2f3fc] rounded-xl border border-[#e1e2eb] hover:border-[#0066cc] il-card-hover transition-all cursor-pointer"
                    >
                        <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center mb-3 border border-[#e1e2eb] group-hover:border-[#0066cc] transition-colors">
                            @if($cert->getFirstMedia('logo'))
                                <img src="{{ $cert->getFirstMediaUrl('logo') }}" alt="{{ $cert->name }}" class="w-8 h-8 object-contain">
                            @else
                                <x-icon name="shield-check" class="w-7 h-7 text-[#0066cc]" />
                            @endif
                        </div>
                        <span class="text-xs font-bold text-[#414753] text-center uppercase tracking-wider leading-tight">{{ td($cert->name) }}</span>
                        @if(!$cert->isExpired() && $cert->expires_at)
                            <span class="mt-2 text-[10px] font-bold text-green-600 bg-green-50 border border-green-100 px-1.5 py-0.5 rounded-full">{{ __('site.home.cert_valid') }}</span>
                        @elseif($cert->isExpired())
                            <span class="mt-2 text-[10px] font-bold text-red-500 bg-red-50 border border-red-100 px-1.5 py-0.5 rounded-full">{{ __('site.home.cert_expired') }}</span>
                        @endif
                    </button>
                @endforeach
            </div>

            <div class="text-center">
                <a href="{{ route('certifications.index') }}"
                   class="inline-flex items-center gap-2 text-sm font-bold text-[#0066cc] hover:text-[#004e9f] transition">
                    {{ __('site.home.certifications_see_all') }} <x-icon name="arrow-right" class="w-4 h-4" />
                </a>
            </div>

            {{-- Modal --}}
            <div
                x-show="open"
                x-transition:enter="transition duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition duration-150"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
                @click.self="open = false"
                style="display:none"
            >
                <div
                    x-show="open"
                    x-transition:enter="transition duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition duration-150"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden border border-[#e1e2eb]"
                >
                    <div class="flex items-center justify-between px-6 py-4 border-b border-[#e1e2eb]">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-[#d7e3ff] flex items-center justify-center shrink-0">
                                <template x-if="cert.logo_url">
                                    <img :src="cert.logo_url" :alt="cert.name" class="w-6 h-6 object-contain">
                                </template>
                                <template x-if="!cert.logo_url">
                                    <x-icon name="shield-check" class="w-5 h-5 text-[#0066cc]" />
                                </template>
                            </div>
                            <h3 x-text="cert.name" class="text-base font-bold text-[#191c22]"></h3>
                        </div>
                        <button @click="open = false" class="text-[#727784] hover:text-[#191c22] transition">
                            <x-icon name="x-mark" class="w-5 h-5" />
                        </button>
                    </div>
                    <div class="px-6 py-5 space-y-4">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-xs text-[#727784] mb-0.5 uppercase tracking-wider">{{ __('site.home.cert_issuer') }}</p>
                                <p class="font-semibold text-[#191c22]" x-text="cert.issuer"></p>
                            </div>
                            <template x-if="cert.certificate_number">
                                <div>
                                    <p class="text-xs text-[#727784] mb-0.5 uppercase tracking-wider">{{ __('site.home.cert_number') }}</p>
                                    <p class="font-semibold text-[#191c22]" x-text="cert.certificate_number"></p>
                                </div>
                            </template>
                            <template x-if="cert.issued_at">
                                <div>
                                    <p class="text-xs text-[#727784] mb-0.5 uppercase tracking-wider">{{ __('site.home.cert_issued_at') }}</p>
                                    <p class="font-semibold text-[#191c22]" x-text="cert.issued_at"></p>
                                </div>
                            </template>
                            <template x-if="cert.expires_at">
                                <div>
                                    <p class="text-xs text-[#727784] mb-0.5 uppercase tracking-wider">{{ __('site.home.cert_expires_at') }}</p>
                                    <p class="font-semibold" :class="cert.is_expired ? 'text-red-500' : 'text-green-600'" x-text="cert.expires_at"></p>
                                </div>
                            </template>
                        </div>
                        <template x-if="cert.description">
                            <div>
                                <p class="text-xs text-[#727784] mb-1 uppercase tracking-wider">{{ __('site.home.cert_description') }}</p>
                                <p class="text-sm text-[#414753] leading-relaxed" x-text="cert.description"></p>
                            </div>
                        </template>
                        <template x-if="cert.cert_url">
                            <div>
                                <a :href="cert.cert_url" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[#d7e3ff] border border-[#aac7ff] text-[#004e9f] text-sm font-bold hover:bg-[#aac7ff] transition">
                                    <x-icon name="document-arrow-down" class="w-4 h-4" />
                                    {{ __('site.home.cert_view_pdf') }}
                                </a>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif


{{-- ══════════════════════════════════════════════════
     4. SERVIÇOS
══════════════════════════════════════════════════ --}}
<section
    id="services"
    class="py-24 bg-[#f9f9ff] border-t border-[#e1e2eb] transition-all duration-700 ease-out"
    x-data="{ shown: false }"
    x-init="new IntersectionObserver(([e]) => { if (e.isIntersecting) { shown = true } }, { threshold: 0.08 }).observe($el)"
    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
>
    <div class="max-w-7xl mx-auto px-6 md:px-12">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-14">
            <div>
                <p class="text-xs font-bold tracking-widest text-[#0066cc] uppercase mb-2">{{ __('site.home.services_tag') }}</p>
                <h2 class="text-4xl font-bold text-[#191c22] tracking-tight">{{ __('site.home.services_title') }}</h2>
            </div>
            <a href="{{ route('services.index') }}"
               class="inline-flex items-center gap-2 text-sm font-bold text-[#0066cc] hover:text-[#004e9f] transition shrink-0">
                {{ __('site.home.services_see_all') }} <x-icon name="arrow-right" class="w-4 h-4" />
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($services as $service)
                <a href="{{ route('services.index') }}"
                   class="group flex flex-col bg-white rounded-xl border border-[#e1e2eb] overflow-hidden il-card-hover transition-all duration-300 hover:-translate-y-1"
                   style="transition-delay: {{ $loop->index * 80 }}ms">

                    @if($service->getFirstMedia('cover'))
                        <img src="{{ $service->getFirstMediaUrl('cover', 'thumb') }}"
                             alt="{{ td($service->title) }}"
                             class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-40 bg-[#ecedf6] flex items-center justify-center">
                            <x-icon name="wrench-screwdriver" class="w-10 h-10 text-[#c1c6d5]" />
                        </div>
                    @endif

                    <div class="p-6 flex flex-col gap-2 flex-1">
                        <div class="w-10 h-10 rounded-lg bg-[#d7e3ff] flex items-center justify-center mb-1 group-hover:bg-[#0066cc] transition-colors">
                            <x-icon name="{{ $service->icon ?? 'cog-6-tooth' }}" class="w-5 h-5 text-[#0066cc] group-hover:text-white transition-colors" />
                        </div>
                        <h3 class="text-base font-bold text-[#191c22] group-hover:text-[#0066cc] transition-colors">
                            {{ td($service->title) }}
                        </h3>
                        @if($service->subtitle)
                            <p class="text-xs font-semibold text-[#727784] uppercase tracking-wider">{{ td($service->subtitle) }}</p>
                        @endif
                        <p class="text-sm text-[#414753] leading-relaxed line-clamp-3 mt-auto">
                            {!! td(strip_tags($service->description)) !!}
                        </p>
                        <span class="mt-3 text-sm font-bold text-[#0066cc] flex items-center gap-1 group-hover:gap-2 transition-all">
                            {{ __('site.common.learn_more') }} <x-icon name="chevron-right" class="w-4 h-4" />
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════════════
     5. PORTFÓLIO
══════════════════════════════════════════════════ --}}
<section
    id="portfolio"
    class="py-24 bg-white border-t border-[#e1e2eb] transition-all duration-700 ease-out"
    x-data="{ shown: false }"
    x-init="new IntersectionObserver(([e]) => { if (e.isIntersecting) { shown = true } }, { threshold: 0.08 }).observe($el)"
    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
>
    <div class="max-w-7xl mx-auto px-6 md:px-12">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-14">
            <div class="max-w-xl">
                <p class="text-xs font-bold tracking-widest text-[#0066cc] uppercase mb-2">{{ __('site.home.portfolio_tag') }}</p>
                <h2 class="text-4xl font-bold text-[#191c22] tracking-tight">{{ __('site.home.portfolio_title') }}</h2>
            </div>
        </div>

        @if($featuredItems->isEmpty())
            <div class="text-center py-20 text-[#727784] text-sm">{{ __('site.home.portfolio_empty') }}</div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($featuredItems as $item)
                    <a href="{{ route('portfolio.index') }}"
                       class="group relative rounded-xl overflow-hidden bg-[#ecedf6] border border-[#e1e2eb] il-card-hover transition-all duration-300 hover:-translate-y-1 block aspect-[4/3]"
                       style="transition-delay: {{ $loop->index * 80 }}ms">

                        @if($item->getFirstMedia('cover'))
                            <img src="{{ $item->getFirstMediaUrl('cover', 'thumb') ?: $item->getFirstMediaUrl('cover') }}"
                                 alt="{{ td($item->title) }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <x-icon name="photo" class="w-12 h-12 text-[#c1c6d5]" />
                            </div>
                        @endif

                        <div class="absolute inset-0 bg-gradient-to-t from-[#191c22]/80 via-[#191c22]/20 to-transparent opacity-60 group-hover:opacity-90 transition-opacity"></div>

                        <div class="absolute bottom-0 left-0 p-5 w-full">
                            @if($item->category)
                                <span class="inline-block text-xs font-bold text-white bg-[#0066cc] px-2 py-0.5 rounded mb-2 uppercase tracking-wider">
                                    {{ ucfirst($item->category) }}
                                </span>
                            @endif
                            <h3 class="text-sm font-bold text-white leading-snug">{{ td($item->title) }}</h3>
                            @if($item->subtitle)
                                <p class="text-xs text-white/70 mt-1">{{ td($item->subtitle) }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('portfolio.index') }}"
                   class="inline-flex items-center gap-2 text-sm font-bold text-[#0066cc] hover:text-[#004e9f] transition">
                    {{ __('site.home.portfolio_see_all') }} <x-icon name="arrow-right" class="w-4 h-4" />
                </a>
            </div>
        @endif
    </div>
</section>


{{-- ══════════════════════════════════════════════════
     6. CATÁLOGO
══════════════════════════════════════════════════ --}}
@if($featuredCatalogItems->isNotEmpty())
<section
    id="catalog"
    class="py-24 bg-[#f9f9ff] border-t border-[#e1e2eb] transition-all duration-700 ease-out"
    x-data="{ shown: false }"
    x-init="new IntersectionObserver(([e]) => { if (e.isIntersecting) { shown = true } }, { threshold: 0.08 }).observe($el)"
    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
>
    <div class="max-w-7xl mx-auto px-6 md:px-12">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-14">
            <div>
                <p class="text-xs font-bold tracking-widest text-[#0066cc] uppercase mb-2">{{ __('site.home.catalog_tag') }}</p>
                <h2 class="text-4xl font-bold text-[#191c22] tracking-tight">{{ __('site.home.catalog_title') }}</h2>
            </div>
            <a href="{{ route('catalog.index') }}"
               class="inline-flex items-center gap-2 text-sm font-bold text-[#0066cc] hover:text-[#004e9f] transition shrink-0">
                {{ __('site.home.catalog_see_all') }} <x-icon name="arrow-right" class="w-4 h-4" />
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredCatalogItems as $catalogItem)
                <div class="group bg-white rounded-xl border border-[#e1e2eb] overflow-hidden il-card-hover transition-all duration-300 hover:-translate-y-1"
                     style="transition-delay: {{ $loop->index * 80 }}ms">

                    @if($catalogItem->getFirstMedia('cover'))
                        <img src="{{ $catalogItem->getFirstMediaUrl('cover', 'thumb') }}"
                             alt="{{ td($catalogItem->title) }}"
                             class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-44 bg-[#ecedf6] flex items-center justify-center">
                            <x-icon name="photo" class="w-10 h-10 text-[#c1c6d5]" />
                        </div>
                    @endif

                    <div class="p-5">
                        @if($catalogItem->category)
                            <span class="inline-block text-xs font-bold text-[#0066cc] bg-[#d7e3ff] border border-[#aac7ff] px-2 py-0.5 rounded-full mb-2">
                                {{ td($catalogItem->category->name) }}
                            </span>
                        @endif
                        <h3 class="text-sm font-bold text-[#191c22] mb-1 group-hover:text-[#0066cc] transition-colors leading-snug">
                            {{ td($catalogItem->title) }}
                        </h3>
                        @if($catalogItem->reference)
                            <p class="text-xs text-[#727784] mb-2">{{ __('site.common.ref') }}: {{ $catalogItem->reference }}</p>
                        @endif
                        @if($catalogItem->description)
                            <p class="text-xs text-[#414753] leading-relaxed line-clamp-2">
                                {!! td(strip_tags($catalogItem->description)) !!}
                            </p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif


{{-- ══════════════════════════════════════════════════
     7. CLIENTES
══════════════════════════════════════════════════ --}}
@if($clients->isNotEmpty())
<section
    id="clientes"
    class="py-24 bg-white border-t border-[#e1e2eb] transition-all duration-700 ease-out"
    x-data="{ shown: false }"
    x-init="new IntersectionObserver(([e]) => { if (e.isIntersecting) { shown = true } }, { threshold: 0.08 }).observe($el)"
    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
>
    <div class="max-w-7xl mx-auto px-6 md:px-12">

        <div class="text-center mb-12">
            <p class="text-xs font-bold tracking-widest text-[#0066cc] uppercase mb-2">{{ __('site.home.testimonials_tag') }}</p>
            <h2 class="text-4xl font-bold text-[#191c22] tracking-tight">{{ __('site.home.testimonials_title') }}</h2>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($clients as $client)
                <div class="group flex flex-col items-center gap-4 p-6 bg-[#f9f9ff] rounded-xl border border-[#e1e2eb] il-card-hover transition-all duration-300"
                     style="transition-delay: {{ $loop->index * 80 }}ms">

                    @if($client->getFirstMedia('logo'))
                        <div class="w-20 h-20 rounded-xl bg-white border border-[#e1e2eb] flex items-center justify-center overflow-hidden p-2 group-hover:border-[#0066cc] transition-colors">
                            <img src="{{ $client->getFirstMediaUrl('logo') }}"
                                 alt="{{ $client->name }}"
                                 class="w-full h-full object-contain">
                        </div>
                    @else
                        <div class="w-20 h-20 rounded-xl bg-[#d7e3ff] border border-[#aac7ff] flex items-center justify-center group-hover:border-[#0066cc] transition-colors">
                            <span class="text-xl font-bold text-[#0066cc]">{{ strtoupper(substr($client->name, 0, 2)) }}</span>
                        </div>
                    @endif

                    <p class="text-sm font-semibold text-[#191c22] text-center leading-snug">{{ $client->name }}</p>

                    @if($client->testimonial)
                        <p class="text-xs text-[#727784] text-center leading-relaxed line-clamp-3 italic">"{{ $client->testimonial }}"</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif


{{-- ══════════════════════════════════════════════════
     8. NOTÍCIAS
══════════════════════════════════════════════════ --}}
@if($latestNews->isNotEmpty())
<section
    id="noticias"
    class="py-24 bg-[#f9f9ff] border-t border-[#e1e2eb] transition-all duration-700 ease-out"
    x-data="{ shown: false }"
    x-init="new IntersectionObserver(([e]) => { if (e.isIntersecting) { shown = true } }, { threshold: 0.08 }).observe($el)"
    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
>
    <div class="max-w-7xl mx-auto px-6 md:px-12">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-14">
            <div>
                <p class="text-xs font-bold tracking-widest text-[#0066cc] uppercase mb-2">{{ __('site.home.news_tag') }}</p>
                <h2 class="text-4xl font-bold text-[#191c22] tracking-tight">{{ __('site.home.news_title') }}</h2>
            </div>
            <a href="{{ route('news.index') }}"
               class="inline-flex items-center gap-2 text-sm font-bold text-[#0066cc] hover:text-[#004e9f] transition shrink-0">
                {{ __('site.home.news_see_all') }} <x-icon name="arrow-right" class="w-4 h-4" />
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($latestNews as $item)
                <a href="{{ route('news.show', $item->slug) }}"
                   class="group bg-white rounded-xl border border-[#e1e2eb] overflow-hidden il-card-hover transition-all duration-300 hover:-translate-y-1 block"
                   style="transition-delay: {{ $loop->index * 80 }}ms">

                    @if($item->getFirstMedia('cover'))
                        <img src="{{ $item->getFirstMediaUrl('cover', 'thumb') ?: $item->getFirstMediaUrl('cover') }}"
                             alt="{{ $item->title }}"
                             class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-44 bg-[#ecedf6] flex items-center justify-center">
                            <x-icon name="newspaper" class="w-10 h-10 text-[#c1c6d5]" />
                        </div>
                    @endif

                    <div class="p-5">
                        @if($item->published_at)
                            <p class="text-xs text-[#0066cc] font-bold uppercase tracking-wider mb-2">
                                {{ $item->published_at->format('d/m/Y') }}
                            </p>
                        @endif
                        <h3 class="text-sm font-bold text-[#191c22] mb-2 group-hover:text-[#0066cc] transition-colors leading-snug">
                            {{ $item->title }}
                        </h3>
                        @if($item->excerpt)
                            <p class="text-xs text-[#414753] leading-relaxed line-clamp-3">{{ $item->excerpt }}</p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif


{{-- ══════════════════════════════════════════════════
     9. CONTATO
══════════════════════════════════════════════════ --}}
<section
    id="contact"
    class="py-24 bg-[#004e9f] relative overflow-hidden transition-all duration-700 ease-out"
    x-data="{ shown: false }"
    x-init="new IntersectionObserver(([e]) => { if (e.isIntersecting) { shown = true } }, { threshold: 0.05 }).observe($el)"
    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
>
    <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-[600px] h-[600px] rounded-full bg-white/5 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] rounded-full bg-[#0066cc]/30 blur-3xl pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto px-6 md:px-12">

        <div class="text-center mb-14">
            <p class="text-xs font-bold tracking-widest text-[#aac7ff] uppercase mb-2">{{ __('site.home.contact_tag') }}</p>
            <h2 class="text-4xl font-bold text-white tracking-tight mb-3">{{ __('site.home.contact_title') }}</h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-[#aac7ff] mb-5">{{ __('site.home.contact_info_title') }}</h3>
                    <ul class="space-y-4">
                        @if($siteContent->contact_email)
                        <li class="flex items-start gap-4 p-4 rounded-lg bg-white/5 border border-white/10 hover:border-white/30 transition-colors">
                            <x-icon name="envelope" class="w-5 h-5 text-white mt-0.5 shrink-0" />
                            <div>
                                <p class="text-xs text-[#aac7ff] mb-0.5">{{ __('site.home.contact_email') }}</p>
                                <a href="mailto:{{ $siteContent->contact_email }}" class="text-sm font-semibold text-white hover:text-[#d7e3ff] transition">{{ $siteContent->contact_email }}</a>
                            </div>
                        </li>
                        @endif
                        @if($siteContent->phone)
                        <li class="flex items-start gap-4 p-4 rounded-lg bg-white/5 border border-white/10 hover:border-white/30 transition-colors">
                            <x-icon name="phone" class="w-5 h-5 text-white mt-0.5 shrink-0" />
                            <div>
                                <p class="text-xs text-[#aac7ff] mb-0.5">{{ __('site.home.contact_phone') }}</p>
                                <a href="tel:{{ preg_replace('/\D/', '', $siteContent->phone) }}" class="text-sm font-semibold text-white hover:text-[#d7e3ff] transition">{{ $siteContent->phone }}</a>
                            </div>
                        </li>
                        @endif
                        @if($siteContent->whatsapp_url)
                        <li class="flex items-start gap-4 p-4 rounded-lg bg-white/5 border border-white/10 hover:border-white/30 transition-colors">
                            <x-icon name="chat-bubble-left-ellipsis" class="w-5 h-5 text-white mt-0.5 shrink-0" />
                            <div>
                                <p class="text-xs text-[#aac7ff] mb-0.5">{{ __('site.home.contact_whatsapp') }}</p>
                                <a href="{{ $siteContent->whatsapp_url }}" target="_blank" rel="noopener noreferrer" class="text-sm font-semibold text-white hover:text-[#d7e3ff] transition">WhatsApp</a>
                            </div>
                        </li>
                        @endif
                        @if($siteContent->address)
                        <li class="flex items-start gap-4 p-4 rounded-lg bg-white/5 border border-white/10 hover:border-white/30 transition-colors">
                            <x-icon name="map-pin" class="w-5 h-5 text-white mt-0.5 shrink-0" />
                            <div>
                                <p class="text-xs text-[#aac7ff] mb-0.5">{{ __('site.home.contact_address') }}</p>
                                <p class="text-sm font-semibold text-white leading-snug">{{ $siteContent->address }}</p>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>

            </div>

            <div class="lg:col-span-7 bg-white rounded-xl border border-[#e1e2eb] p-7 lg:p-10 shadow-2xl">
                <h3 class="text-lg font-bold text-[#191c22] mb-6 flex items-center gap-2">
                    <x-icon name="document-text" class="w-5 h-5 text-[#0066cc]" />
                    {{ __('site.home.contact_title') }}
                </h3>
                <livewire:quote-form />
            </div>
        </div>
    </div>
</section>

@endsection
