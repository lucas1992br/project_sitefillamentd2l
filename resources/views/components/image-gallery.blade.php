{{--
    Componente de galeria com carrossel Alpine.js.

    Props:
      images  — array: { thumb, full, alt, title?, subtitle?, description? }
      height  — altura do carrossel no card (default: h-52)
      overlay — exibir título/subtítulo sobre a imagem (default: false)

    Uso:
      <x-image-gallery :images="$imagesArray" height="h-48" />
--}}
@props([
    'images',
    'height'  => 'h-52',
    'overlay' => false,
])

@php
    $images = collect($images)->values();
@endphp

@if ($images->isEmpty())
    <div class="w-full {{ $height }} bg-[#ecedf6] flex items-center justify-center">
        <svg class="w-10 h-10 text-[#c1c6d5]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5z"/>
        </svg>
    </div>
@else
<div
    x-data="{
        active: 0,
        open: false,
        images: {{ $images->toJson() }},
        touchStartX: 0,
        touchStartY: 0,

        prev() {
            this.active = (this.active - 1 + this.images.length) % this.images.length;
        },
        next() {
            this.active = (this.active + 1) % this.images.length;
        },
        openGallery() {
            this.open = true;
            document.body.style.overflow = 'hidden';
        },
        closeGallery() {
            this.open = false;
            document.body.style.overflow = '';
        },
        handleTouchStart(e) {
            this.touchStartX = e.changedTouches[0].screenX;
            this.touchStartY = e.changedTouches[0].screenY;
        },
        handleTouchEnd(e) {
            const dx = this.touchStartX - e.changedTouches[0].screenX;
            const dy = this.touchStartY - e.changedTouches[0].screenY;
            if (Math.abs(dx) > 40 && Math.abs(dx) > Math.abs(dy)) {
                dx > 0 ? this.next() : this.prev();
            }
        },
    }"
    @keydown.escape.window="if (open) closeGallery()"
    @keydown.arrow-left.window="if (open) prev()"
    @keydown.arrow-right.window="if (open) next()"
>

    {{-- ══════════════════════════════════════════════════
         CARROSSEL NO CARD
    ══════════════════════════════════════════════════ --}}
    <div
        class="relative w-full {{ $height }} overflow-hidden group"
        @touchstart.passive="handleTouchStart($event)"
        @touchend="handleTouchEnd($event)"
    >
        {{-- Track deslizante --}}
        <div
            class="flex h-full"
            :style="`transform: translateX(-${active * 100}%); transition: transform 0.4s cubic-bezier(0.4,0,0.2,1);`"
        >
            @foreach ($images as $index => $image)
                <div
                    class="relative h-full cursor-pointer shrink-0 w-full"
                    @click="openGallery()"
                >
                    <img
                        src="{{ $image['thumb'] }}"
                        alt="{{ $image['alt'] ?? '' }}"
                        loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                        class="w-full h-full object-cover"
                    >

                    {{-- Overlay informativo --}}
                    @if ($overlay && ($image['title'] ?? null))
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent p-3 pointer-events-none">
                            <p class="text-white text-sm font-bold leading-snug">{{ $image['title'] }}</p>
                            @if ($image['subtitle'] ?? null)
                                <p class="text-white/75 text-xs mt-0.5">{{ $image['subtitle'] }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        @if ($images->count() > 1)
            {{-- Seta anterior --}}
            <button
                @click.stop="prev()"
                aria-label="Imagem anterior"
                class="absolute left-2 top-1/2 -translate-y-1/2 z-10
                       bg-black/50 hover:bg-black/75 text-white
                       w-8 h-8 rounded-full flex items-center justify-center
                       opacity-0 group-hover:opacity-100
                       transition-opacity duration-200 text-xl leading-none"
            >&#8249;</button>

            {{-- Seta próxima --}}
            <button
                @click.stop="next()"
                aria-label="Próxima imagem"
                class="absolute right-2 top-1/2 -translate-y-1/2 z-10
                       bg-black/50 hover:bg-black/75 text-white
                       w-8 h-8 rounded-full flex items-center justify-center
                       opacity-0 group-hover:opacity-100
                       transition-opacity duration-200 text-xl leading-none"
            >&#8250;</button>

            {{-- Indicadores de página --}}
            <div class="absolute bottom-2 left-1/2 -translate-x-1/2 z-10 flex items-center gap-1.5">
                @foreach ($images as $index => $image)
                    <button
                        @click.stop="active = {{ $index }}"
                        :class="{{ $index }} === active ? 'bg-white w-4' : 'bg-white/50 w-1.5'"
                        class="h-1.5 rounded-full transition-all duration-300"
                        aria-label="Ir para imagem {{ $index + 1 }}"
                    ></button>
                @endforeach
            </div>

            {{-- Contador --}}
            <div class="absolute top-2 right-2 z-10 bg-black/50 text-white text-xs px-2 py-0.5 rounded-full">
                <span x-text="active + 1"></span>/{{ $images->count() }}
            </div>
        @endif

        {{-- Ícone de expandir --}}
        <div class="absolute top-2 left-2 z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-200
                    bg-black/50 text-white w-7 h-7 rounded-full flex items-center justify-center pointer-events-none">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15"/>
            </svg>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════
         LIGHTBOX FULLSCREEN (x-teleport escapa de transforms)
    ══════════════════════════════════════════════════ --}}
    <template x-teleport="body">
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[9999] bg-black/95 flex flex-col select-none"
            style="display: none;"
            role="dialog"
            aria-modal="true"
            @touchstart.passive="handleTouchStart($event)"
            @touchend="handleTouchEnd($event)"
        >
            {{-- Barra superior --}}
            <div class="shrink-0 flex items-center justify-between px-4 py-3">
                <span class="text-white/50 text-sm tabular-nums" x-show="images.length > 1">
                    <span x-text="active + 1"></span>&nbsp;/&nbsp;<span x-text="images.length"></span>
                </span>
                <span x-show="images.length === 1"></span>

                <div class="flex-1 text-center px-4 overflow-hidden">
                    <p x-text="images[active]?.title ?? ''" class="text-white text-sm font-semibold truncate" x-show="images[active]?.title"></p>
                    <p x-text="images[active]?.subtitle ?? ''" class="text-white/50 text-xs mt-0.5 truncate" x-show="images[active]?.subtitle"></p>
                </div>

                <button
                    @click="closeGallery()"
                    aria-label="Fechar"
                    class="w-9 h-9 flex items-center justify-center rounded-full text-white/60 hover:text-white hover:bg-white/10 transition"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Área de imagem com carrossel --}}
            <div class="flex-1 relative overflow-hidden" @click.self="closeGallery()">

                {{-- Track --}}
                <div
                    class="flex h-full"
                    :style="`transform: translateX(-${active * 100}%); transition: transform 0.4s cubic-bezier(0.4,0,0.2,1);`"
                >
                    <template x-for="(img, i) in images" :key="i">
                        <div
                            class="flex items-center justify-center p-4 shrink-0 w-full"
                            @click.self="closeGallery()"
                        >
                            <img
                                :src="img.full"
                                :alt="img.alt || ''"
                                class="max-w-full max-h-full object-contain pointer-events-none"
                                draggable="false"
                            >
                        </div>
                    </template>
                </div>

                {{-- Setas --}}
                <button
                    x-show="images.length > 1"
                    @click.stop="prev()"
                    aria-label="Anterior"
                    class="absolute left-3 top-1/2 -translate-y-1/2 z-10
                           bg-white/10 hover:bg-white/25 text-white
                           w-11 h-11 rounded-full flex items-center justify-center
                           transition text-2xl leading-none"
                >&#8249;</button>

                <button
                    x-show="images.length > 1"
                    @click.stop="next()"
                    aria-label="Próxima"
                    class="absolute right-3 top-1/2 -translate-y-1/2 z-10
                           bg-white/10 hover:bg-white/25 text-white
                           w-11 h-11 rounded-full flex items-center justify-center
                           transition text-2xl leading-none"
                >&#8250;</button>
            </div>

            {{-- Rodapé: descrição + miniaturas --}}
            <div class="shrink-0 pb-4 pt-2">
                <template x-if="images[active]?.description">
                    <p x-text="images[active].description"
                       class="text-white/40 text-xs text-center px-8 mb-3 line-clamp-2"></p>
                </template>

                <div x-show="images.length > 1" class="flex justify-center gap-1.5 px-4 overflow-x-auto">
                    <template x-for="(img, i) in images" :key="'th-' + i">
                        <button
                            @click="active = i"
                            :class="active === i ? 'ring-2 ring-white opacity-100 scale-105' : 'opacity-40 hover:opacity-70'"
                            class="shrink-0 w-14 h-10 rounded overflow-hidden transition-all duration-200 focus:outline-none"
                            :aria-label="'Ver imagem ' + (i + 1)"
                        >
                            <img :src="img.thumb" :alt="img.alt || ''" loading="lazy" class="w-full h-full object-cover">
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </template>
</div>
@endif
