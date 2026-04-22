@extends('layouts.site')

@section('title', 'D2L — Soluções em metálicas')
@section('description', 'Usinagem CNC, solda, torneamento e acabamento certificados ISO 9001. Tolerâncias de ±0.003 mm desde 2005.')

@section('content')

{{-- ══════════════════════════════════════════════════
     1. HERO
══════════════════════════════════════════════════ --}}
<section class="relative min-h-screen bg-tech-grid flex flex-col justify-center overflow-hidden">

    {{-- Video background --}}
    @if($siteContent->showcase_video_active && $siteContent->getFirstMedia('showcase_video'))
        <video
            autoplay muted loop playsinline
            class="absolute inset-0 w-full h-full object-cover opacity-20 pointer-events-none"
        >
            <source src="{{ $siteContent->getFirstMediaUrl('showcase_video') }}" type="video/mp4">
        </video>
    @endif

    {{-- Radial glow --}}
    <div class="absolute inset-0 pointer-events-none"
         style="background: radial-gradient(ellipse 80% 60% at 50% 40%, rgba(36,116,196,0.12) 0%, transparent 70%);">
    </div>

    {{-- Scan line accent --}}
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-blue-500/60 to-transparent"></div>

    <div class="relative max-w-7xl mx-auto px-6 pt-28 pb-20 w-full">
        <div class="max-w-3xl">

            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-blue-500/30 bg-blue-500/10 mb-8">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
                <span class="text-xs font-medium text-blue-300 tracking-widest uppercase">ISO 9001 Certificado · Desde 2005</span>
            </div>

            {{-- Headline --}}
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold leading-[1.05] tracking-tight mb-6">
                <span class="text-white">Precisão que</span><br>
                <span class="text-gradient-blue">Move a Indústria</span>
            </h1>

            <p class="text-blue-200/70 text-lg md:text-xl leading-relaxed max-w-xl mb-10">
                Torneamento CNC, fresamento 5 eixos, soldagem certificada e acabamento superficial —
                tolerâncias de <strong class="text-blue-300 font-semibold">±0.003 mm</strong> para os setores mais exigentes.
            </p>

            <div class="flex flex-wrap gap-4">
                <a href="#contact"
                   class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full bg-blue-500 text-white font-semibold text-sm hover:bg-blue-400 transition-all shadow-lg shadow-blue-500/30 hover:shadow-blue-400/40 hover:-translate-y-0.5">
                    <x-icon name="document-text" class="w-4 h-4" />
                    Solicite um Orçamento
                </a>
                <a href="#portfolio"
                   class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full border border-blue-500/40 text-blue-200 font-semibold text-sm hover:border-blue-400 hover:text-white transition-all hover:-translate-y-0.5">
                    <x-icon name="photo" class="w-4 h-4" />
                    Ver Portfólio
                </a>
            </div>

            {{-- Ícones de redes sociais --}}
            @if($siteContent->whatsapp_url || $siteContent->facebook_url || $siteContent->instagram_url)
                <div class="flex items-center gap-3 mt-2">
                    <span class="text-xs text-blue-400/60 uppercase tracking-widest">Siga-nos</span>
                    <div class="h-px w-6 bg-blue-500/30"></div>

                    @if($siteContent->whatsapp_url)
                        <a href="{{ $siteContent->whatsapp_url }}" target="_blank" rel="noopener noreferrer"
                           class="w-9 h-9 rounded-full bg-white/5 border border-white/10 hover:bg-[#25D366]/20 hover:border-[#25D366]/50 flex items-center justify-center transition-all hover:-translate-y-0.5"
                           title="WhatsApp">
                            <svg class="w-4 h-4 text-white/70 hover:text-[#25D366] transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </a>
                    @endif

                    @if($siteContent->facebook_url)
                        <a href="{{ $siteContent->facebook_url }}" target="_blank" rel="noopener noreferrer"
                           class="w-9 h-9 rounded-full bg-white/5 border border-white/10 hover:bg-[#1877F2]/20 hover:border-[#1877F2]/50 flex items-center justify-center transition-all hover:-translate-y-0.5"
                           title="Facebook">
                            <svg class="w-4 h-4 text-white/70 hover:text-[#1877F2] transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                    @endif

                    @if($siteContent->instagram_url)
                        <a href="{{ $siteContent->instagram_url }}" target="_blank" rel="noopener noreferrer"
                           class="w-9 h-9 rounded-full bg-white/5 border border-white/10 hover:bg-pink-500/20 hover:border-pink-500/50 flex items-center justify-center transition-all hover:-translate-y-0.5"
                           title="Instagram">
                            <svg class="w-4 h-4 text-white/70 hover:text-pink-400 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                    @endif
                </div>
            @endif
        </div>

        {{-- Stats strip --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-20 pt-10 border-t border-white/5">
            @foreach([
                ['value' => '20+',      'unit' => 'Anos',       'label' => 'de experiência'],
                ['value' => '500+',     'unit' => 'Projetos',   'label' => 'entregues'],
                ['value' => '±0.003',   'unit' => 'mm',         'label' => 'tolerância mínima'],
                ['value' => 'ISO',      'unit' => '9001',       'label' => 'certificação ativa'],
            ] as $stat)
                <div class="text-center md:text-left">
                    <p class="text-3xl md:text-4xl font-bold text-white stat-glow">
                        {{ $stat['value'] }}<span class="text-blue-400 text-2xl">{{ $stat['unit'] }}</span>
                    </p>
                    <p class="text-xs text-blue-400/70 uppercase tracking-widest mt-1">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Bottom fade --}}
    <div class="absolute bottom-0 left-0 right-0 h-24 pointer-events-none"
         style="background: linear-gradient(to bottom, transparent, #f8fafc);">
    </div>
</section>

{{-- ══════════════════════════════════════════════════
     3. SERVIÇOS
══════════════════════════════════════════════════ --}}
<section id="services" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-14">
            <div>
                <p class="text-xs font-semibold tracking-widest text-blue-500 uppercase mb-2">O que fazemos</p>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900">Nossos Serviços</h2>
            </div>
            <a href="{{ route('services.index') }}"
               class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 hover:text-blue-500 transition shrink-0">
                Ver todos os serviços <x-icon name="arrow-right" class="w-4 h-4" />
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services as $service)
                <a href="{{ route('services.index') }}" class="group relative bg-white rounded-2xl border border-slate-100 p-6 card-glow transition-all duration-300 hover:-translate-y-1 block">
                    {{-- Accent top bar --}}
                    <div class="absolute top-0 left-6 right-6 h-0.5 bg-gradient-to-r from-blue-500 to-blue-300 rounded-full opacity-0 group-hover:opacity-100 transition duration-300"></div>

                    @if($service->getFirstMedia('cover'))
                        <img src="{{ $service->getFirstMediaUrl('cover', 'thumb') }}"
                             alt="{{ $service->title }}"
                             class="w-full h-32 object-cover rounded-lg mb-4">
                    @endif

                    <h3 class="text-base font-bold text-slate-900 mb-1 group-hover:text-blue-600 transition-colors">
                        {{ $service->title }}
                    </h3>

                    @if($service->subtitle)
                        <p class="text-xs font-semibold text-blue-500 uppercase tracking-wider mb-3">{{ $service->subtitle }}</p>
                    @endif

                    <p class="text-sm text-slate-500 leading-relaxed line-clamp-3">
                        {!! strip_tags($service->description) !!}
                    </p>
                </a>
            @endforeach
        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════════════
     3. PORTFÓLIO SHOWCASE
══════════════════════════════════════════════════ --}}
<section id="portfolio" class="py-24 bg-slate-950 relative overflow-hidden">

    {{-- Subtle bg grid --}}
    <div class="absolute inset-0 opacity-40 bg-tech-grid pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto px-6">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-14">
            <div>
                <p class="text-xs font-semibold tracking-widest text-blue-400 uppercase mb-2">Nosso Trabalho</p>
                <h2 class="text-3xl md:text-4xl font-bold text-white">Portfólio de Projetos</h2>
            </div>
            <a href="{{ route('portfolio.index') }}"
               class="inline-flex items-center gap-2 text-sm font-medium text-blue-400 hover:text-blue-300 transition shrink-0">
                Ver portfólio completo <x-icon name="arrow-right" class="w-4 h-4" />
            </a>
        </div>

        @if($featuredItems->isEmpty())
            <div class="text-center py-20 text-slate-500 text-sm">Nenhum projeto em destaque no momento.</div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($featuredItems as $item)
                    <a href="{{ route('portfolio.index') }}" class="group relative rounded-2xl overflow-hidden bg-slate-900 border border-white/5 card-glow transition-all duration-300 hover:-translate-y-1 block">

                        {{-- Imagem de capa --}}
                        @if($item->getFirstMedia('cover'))
                            <img src="{{ $item->getFirstMediaUrl('cover', 'thumb') ?: $item->getFirstMediaUrl('cover') }}"
                                 alt="{{ $item->title }}"
                                 class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-56 bg-slate-800 flex items-center justify-center">
                                <x-icon name="photo" class="w-12 h-12 text-slate-600" />
                            </div>
                        @endif

                        {{-- Footer info --}}
                        <div class="p-5">
                            <div class="flex items-start justify-between gap-2">
                                <h3 class="text-sm font-semibold text-white">{{ $item->title }}</h3>
                                @if($item->category)
                                    <span class="shrink-0 text-xs font-semibold text-blue-400 bg-blue-500/10 border border-blue-500/20 px-2 py-0.5 rounded-full">
                                        {{ ucfirst($item->category) }}
                                    </span>
                                @endif
                            </div>
                            @if($item->subtitle)
                                <p class="text-xs text-slate-400 mt-1">{{ $item->subtitle }}</p>
                            @endif
                            @if($item->material)
                                <p class="text-xs text-slate-500 mt-0.5">Material: {{ $item->material }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>


{{-- ══════════════════════════════════════════════════
     4. VÍDEO SHOWCASE — "EM AÇÃO"
══════════════════════════════════════════════════ --}}
@if($siteContent->showcase_video_active)
<section class="py-24 bg-slate-900 relative hidden">

    <div class="absolute inset-0 pointer-events-none"
         style="background: radial-gradient(ellipse 70% 60% at 50% 50%, rgba(36,116,196,0.08) 0%, transparent 70%);">
    </div>

    <div class="relative max-w-4xl mx-auto px-6 text-center">
        <p class="text-xs font-semibold tracking-widest text-blue-400 uppercase mb-3">Veja em Ação</p>
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Equipamentos Operando</h2>
        <p class="text-slate-400 max-w-xl mx-auto mb-10 leading-relaxed">
            Tornos CNC de última geração, células de soldagem automatizadas e fresadoras 5 eixos
            em operação contínua — qualidade visível em cada peça.
        </p>

        @if($siteContent->getFirstMedia('showcase_video'))
            <div class="rounded-2xl overflow-hidden border border-white/10 shadow-2xl shadow-black/50">
                <video
                    autoplay
                    muted
                    loop
                    playsinline
                    controls
                    class="w-full aspect-video bg-black"
                >
                    <source src="{{ $siteContent->getFirstMediaUrl('showcase_video') }}" type="video/mp4">
                </video>
            </div>
        @else
            {{-- Placeholder com call-to-action para o admin --}}
            <div class="rounded-2xl border-2 border-dashed border-blue-500/20 bg-slate-800/50 aspect-video flex flex-col items-center justify-center gap-4">
                <div class="w-16 h-16 rounded-full border-2 border-blue-500/40 flex items-center justify-center">
                    <x-icon name="play" class="w-7 h-7 text-blue-400 ml-1" />
                </div>
                <div>
                    <p class="text-white font-semibold text-sm mb-1">Vídeo em breve</p>
                    <p class="text-slate-500 text-xs">
                        Faça upload do vídeo em
                        <a href="{{ url('/admin') }}" class="text-blue-400 hover:underline">Admin → Conteúdo do Site</a>
                    </p>
                </div>
            </div>
        @endif
    </div>
</section>
@endif


{{-- ══════════════════════════════════════════════════
     4.5 CATÁLOGO DE PRODUTOS
══════════════════════════════════════════════════ --}}
@if($featuredCatalogItems->isNotEmpty())
<section id="catalog" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-14">
            <div>
                <p class="text-xs font-semibold tracking-widest text-blue-500 uppercase mb-2">Produtos</p>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900">Catálogo de Produtos</h2>
            </div>
            <a href="{{ route('catalog.index') }}"
               class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 hover:text-blue-500 transition shrink-0">
                Ver catálogo completo <x-icon name="arrow-right" class="w-4 h-4" />
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredCatalogItems as $catalogItem)
                <div class="group bg-white rounded-2xl border border-slate-100 overflow-hidden card-glow transition-all duration-300 hover:-translate-y-1 hover:border-blue-200">

                    @if($catalogItem->getFirstMedia('cover'))
                        <img src="{{ $catalogItem->getFirstMediaUrl('cover', 'thumb') }}"
                             alt="{{ $catalogItem->title }}"
                             class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-44 bg-slate-50 flex items-center justify-center border-b border-slate-100">
                            <x-icon name="photo" class="w-10 h-10 text-slate-200" />
                        </div>
                    @endif

                    <div class="p-5">
                        @if($catalogItem->category)
                            <span class="inline-block text-xs font-semibold text-blue-500 bg-blue-50 border border-blue-100 px-2 py-0.5 rounded-full mb-2">
                                {{ $catalogItem->category->name }}
                            </span>
                        @endif

                        <h3 class="text-sm font-bold text-slate-900 mb-1 group-hover:text-blue-600 transition-colors leading-snug">
                            {{ $catalogItem->title }}
                        </h3>

                        @if($catalogItem->reference)
                            <p class="text-xs text-slate-400 mb-2">Ref: {{ $catalogItem->reference }}</p>
                        @endif

                        @if($catalogItem->description)
                            <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">
                                {!! strip_tags($catalogItem->description) !!}
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
     5. POR QUE NOS ESCOLHER
══════════════════════════════════════════════════ --}}
<section class="py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-14">
            <p class="text-xs font-semibold tracking-widest text-blue-500 uppercase mb-2">Vantagens Competitivas</p>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-900">Por que nos escolher</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                [
                    'icon' => 'adjustments-horizontal',
                    'title' => 'Precisão Superior',
                    'desc'  => 'Tolerâncias a partir de ±0.003 mm com controle estatístico de processo (CEP) em cada lote.',
                ],
                [
                    'icon' => 'shield-check',
                    'title' => 'Qualidade Assegurada',
                    'desc'  => 'ISO 9001 e AS9100 — rastreabilidade completa do material ao certificado de conformidade.',
                ],
                [
                    'icon' => 'clock',
                    'title' => 'Entrega no Prazo',
                    'desc'  => '98% dos pedidos entregues dentro do prazo acordado. Capacidade de produção urgente disponível.',
                ],
                [
                    'icon' => 'cpu-chip',
                    'title' => 'Tecnologia de Ponta',
                    'desc'  => 'Centros de usinagem 5 eixos, robôs de solda e CMM de medição de alta resolução.',
                ],
            ] as $item)
                <div class="group bg-white rounded-2xl p-6 border border-slate-100 hover:border-blue-200 card-glow transition-all duration-300 hover:-translate-y-1">
                    <div class="w-11 h-11 rounded-xl bg-blue-500/10 flex items-center justify-center mb-5 group-hover:bg-blue-500 transition-colors duration-300">
                        <x-icon :name="$item['icon']" class="w-5 h-5 text-blue-500 group-hover:text-white transition-colors duration-300" />
                    </div>
                    <h3 class="font-bold text-slate-900 mb-2 group-hover:text-blue-600 transition-colors">{{ $item['title'] }}</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">{{ $item['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════════════
     6. CERTIFICAÇÕES & TESTIMONIALS
══════════════════════════════════════════════════ --}}
<section id="certifications" class="py-24 bg-white relative">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-14">
            <p class="text-xs font-semibold tracking-widest text-blue-500 uppercase mb-2">Qualidade & Conformidade</p>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-900">Certificações</h2>
        </div>

        @if($certifications->isNotEmpty())
            <div class="flex flex-wrap justify-center gap-4 mb-20">
                @foreach($certifications as $cert)
                    <div class="group flex items-center gap-3 bg-white rounded-xl border border-slate-100 px-5 py-3.5 shadow-sm hover:border-blue-200 hover:shadow-md transition-all duration-300">
                        <div class="w-9 h-9 rounded-full bg-blue-50 flex items-center justify-center shrink-0 group-hover:bg-blue-500 transition-colors duration-300">
                            @if($cert->getFirstMedia('logo'))
                                <img src="{{ $cert->getFirstMediaUrl('logo') }}" alt="{{ $cert->name }}" class="w-6 h-6 object-contain">
                            @else
                                <x-icon name="shield-check" class="w-5 h-5 text-blue-500 group-hover:text-white transition-colors duration-300" />
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">{{ $cert->name }}</p>
                            <p class="text-xs text-slate-400">{{ $cert->issuer }}</p>
                        </div>
                        @if(!$cert->isExpired() && $cert->expires_at)
                            <span class="ml-2 text-xs font-semibold text-green-600 bg-green-50 border border-green-100 px-2 py-0.5 rounded-full">Válido</span>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Testimonials --}}
        @if($clients->where('testimonial', '!=', null)->isNotEmpty())
            <div class="text-center mb-10">
                <p class="text-xs font-semibold tracking-widest text-blue-500 uppercase mb-2">Depoimentos</p>
                <h3 class="text-2xl font-bold text-slate-900">O que dizem nossos clientes</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($clients->whereNotNull('testimonial') as $client)
                    <div class="bg-white rounded-2xl border border-slate-100 p-7 shadow-sm hover:shadow-md hover:border-blue-100 transition-all duration-300">
                        {{-- Quote mark --}}
                        <div class="text-5xl font-serif text-blue-100 leading-none mb-3 select-none">"</div>
                        <p class="text-slate-600 leading-relaxed italic mb-6 text-sm">"{{ $client->testimonial }}"</p>
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs font-bold shrink-0">
                                {{ strtoupper(substr($client->contact_name ?? $client->name, 0, 2)) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $client->contact_name ?? $client->name }}</p>
                                @if($client->contact_role)
                                    <p class="text-xs text-slate-400">{{ $client->contact_role }} · {{ $client->name }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
{{-- ══════════════════════════════════════════════════
     2. QUEM SOMOS
══════════════════════════════════════════════════ --}}
@if($siteContent->about_active)
<section id="quem-somos" class="py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            {{-- Texto --}}
            <div>
                <p class="text-xs font-semibold tracking-widest text-primary-600 uppercase mb-3">Quem Somos</p>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-6 leading-tight">
                    {{ $siteContent->about_title }}
                </h2>

                @if($siteContent->about_description)
                    <div class="space-y-4 text-slate-600 leading-relaxed">
                        @foreach(explode("\n", $siteContent->about_description) as $paragraph)
                            @if(trim($paragraph))
                                <p>{{ trim($paragraph) }}</p>
                            @endif
                        @endforeach
                    </div>
                @endif

                @if($siteContent->about_founded_year)
                    <div class="mt-8 inline-flex items-center gap-3 px-5 py-3 rounded-full border border-primary-200 bg-primary-50">
                        <span class="w-2 h-2 rounded-full bg-primary-600"></span>
                        <span class="text-sm font-semibold text-primary-700">
                            Fundada em {{ $siteContent->about_founded_year }} · {{ (int) date('Y') - $siteContent->about_founded_year }} anos de experiência
                        </span>
                    </div>
                @endif
            </div>

            {{-- Imagem ou visual padrão --}}
            <div class="relative">
                @if($siteContent->getFirstMedia('about_image'))
                    <div class="rounded-2xl overflow-hidden shadow-2xl shadow-slate-200">
                        <img
                            src="{{ $siteContent->getFirstMediaUrl('about_image') }}"
                            alt="{{ $siteContent->about_title }}"
                            class="w-full h-80 lg:h-96 object-cover"
                        >
                    </div>
                @else
                    <div class="rounded-2xl bg-slate-100 h-80 lg:h-96 flex flex-col items-center justify-center gap-6 border border-slate-200">
                        <div class="w-16 h-16 rounded-2xl bg-primary-600/10 border border-primary-600/20 flex items-center justify-center">
                            <x-icon name="building-office-2" class="w-8 h-8 text-primary-600" />
                        </div>
                        <div class="text-center px-6">
                            <p class="text-slate-400 text-sm">Adicione uma foto da empresa</p>
                            <p class="text-slate-500 text-xs mt-1">
                                <a href="{{ url('/admin') }}" class="text-primary-600 hover:underline">Admin → Conteúdo do Site</a>
                            </p>
                        </div>
                    </div>
                @endif

                {{-- Accent corner --}}
                <div class="absolute -bottom-4 -right-4 w-24 h-24 rounded-2xl bg-primary-600/10 border border-primary-200 -z-10"></div>
                <div class="absolute -top-4 -left-4 w-16 h-16 rounded-xl bg-slate-100 border border-slate-200 -z-10"></div>
            </div>

        </div>
    </div>
</section>
@endif



{{-- ══════════════════════════════════════════════════
     7. CONTATO & ORÇAMENTO
══════════════════════════════════════════════════ --}}
<section id="contact" class="py-24 bg-slate-950 relative overflow-hidden">

    <div class="absolute inset-0 bg-tech-grid opacity-50 pointer-events-none"></div>
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-blue-500/40 to-transparent"></div>

    <div class="relative max-w-7xl mx-auto px-6">

        <div class="text-center mb-14">
            <p class="text-xs font-semibold tracking-widest text-blue-400 uppercase mb-2">Fale Conosco</p>
            <h2 class="text-3xl md:text-4xl font-bold text-white">Solicite um Orçamento</h2>
            <p class="text-slate-400 mt-3 max-w-lg mx-auto text-sm leading-relaxed">
                Descreva sua peça, material e prazo — respondemos em até 24 horas úteis.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            {{-- Contact info --}}
            <div class="space-y-8">
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-widest text-blue-400 mb-5">Informações de Contato</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-500/10 border border-blue-500/20 flex items-center justify-center shrink-0">
                                <x-icon name="envelope" class="w-4 h-4 text-blue-400" />
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 mb-0.5">E-mail</p>
                                <a href="mailto:contato@d2l.ind.br" class="text-sm text-slate-200 hover:text-blue-300 transition">
                                    contato@d2l.ind.br
                                </a>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-500/10 border border-blue-500/20 flex items-center justify-center shrink-0">
                                <x-icon name="phone" class="w-4 h-4 text-blue-400" />
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 mb-0.5">Telefone</p>
                                <a href="tel:+5512997517673" class="text-sm text-slate-200 hover:text-blue-300 transition">
                                    +55 (12) 99751-7673
                                </a>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-500/10 border border-blue-500/20 flex items-center justify-center shrink-0">
                                <x-icon name="map-pin" class="w-4 h-4 text-blue-400" />
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 mb-0.5">Endereço</p>
                                <p class="text-sm text-slate-200">ROD Doutor Edmir Viana Moura ,5300 <br>VILA PARAISO, CACAPAVA — SP, Brasil</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-500/10 border border-blue-500/20 flex items-center justify-center shrink-0">
                                <x-icon name="clock" class="w-4 h-4 text-blue-400" />
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 mb-0.5">Horário</p>
                                <p class="text-sm text-slate-200">Seg–Sex: 08h–18h</p>
                            </div>
                        </li>
                    </ul>
                </div>

                @if($clients->isNotEmpty())
                    <div>
                        <h3 class="text-xs font-semibold uppercase tracking-widest text-blue-400 mb-4">Confiado por</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($clients->take(4) as $client)
                                <span class="text-xs text-slate-400 bg-white/5 border border-white/10 px-3 py-1.5 rounded-full">
                                    {{ $client->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Form --}}
            <div class="lg:col-span-2 bg-slate-900/70 backdrop-blur-sm rounded-2xl border border-white/5 p-7">
                <livewire:quote-form />
            </div>

        </div>
    </div>
</section>

@endsection
