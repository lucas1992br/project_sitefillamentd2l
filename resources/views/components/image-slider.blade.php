@props([
    'images',
    'height'           => 'h-52',
    'autoplay'         => false,
    'autoplayInterval' => 4000,
    'overlay'          => false,
])

@php
    $images = collect($images)->values();
@endphp

@if ($images->isNotEmpty())
<div
    x-data="{
        active: 0,
        open: false,
        images: {{ $images->toJson() }},
        autoplayEnabled: {{ $autoplay ? 'true' : 'false' }},
        autoplayMs: {{ (int) $autoplayInterval }},
        _timer: null,
        touchStartX: 0,
        touchStartY: 0,
        init() {
            if (this.autoplayEnabled && this.images.length > 1) this.startAutoplay();
            this.preloadNext(0);
        },
        prev() {
            this.active = (this.active - 1 + this.images.length) % this.images.length;
            this.preloadNext(this.active);
            this.resetAutoplay();
        },
        next() {
            this.active = (this.active + 1) % this.images.length;
            this.preloadNext(this.active);
            this.resetAutoplay();
        },
        go(i) {
            this.active = i;
            this.preloadNext(i);
            this.resetAutoplay();
        },
        preloadNext(i) {
            const n = (i + 1) % this.images.length;
            const img = new Image();
            img.src = this.images[n].thumb;
        },
        startAutoplay() { this._timer = setInterval(() => this.next(), this.autoplayMs); },
        stopAutoplay() { clearInterval(this._timer); },
        resetAutoplay() {
            if (this.autoplayEnabled && this.images.length > 1) { this.stopAutoplay(); this.startAutoplay(); }
        },
        handleTouchStart(e) {
            this.touchStartX = e.changedTouches[0].screenX;
            this.touchStartY = e.changedTouches[0].screenY;
        },
        handleTouchEnd(e) {
            const dx = this.touchStartX - e.changedTouches[0].screenX;
            const dy = this.touchStartY - e.changedTouches[0].screenY;
            if (Math.abs(dx) > 50 && Math.abs(dx) > Math.abs(dy)) dx > 0 ? this.next() : this.prev();
        },
    }"
    @keydown.escape.window="open = false"
    @keydown.arrow-left.window="if (open) prev()"
    @keydown.arrow-right.window="if (open) next()"
    class="relative w-full {{ $height }} rounded-lg overflow-hidden group"
    role="region"
    aria-label="Galeria de imagens"
>
    {{-- Slides: x-show garante que apenas 1 slide está no DOM pintado por vez --}}
    <template x-for="(img, i) in images" :key="i">
        <div
            x-show="active === i"
            x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute inset-0"
            @touchstart.passive="handleTouchStart($event)"
            @touchend="handleTouchEnd($event)"
        >
            <img
                :src="img.thumb"
                :alt="img.alt || ''"
                loading="lazy"
                x-on:load="$el.style.opacity = '1'"
                x-on:error="$el.style.display = 'none'"
                x-on:click="open = true"
                style="opacity: 0; transition: opacity 0.3s ease;"
                class="w-full h-full object-cover cursor-pointer"
                :aria-label="img.title || img.alt || ('Imagem ' + (i + 1))"
            >

            {{-- Overlay informativo (prop overlay=true) --}}
            @if ($overlay)
                <template x-if="img.title || img.subtitle || img.description">
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/75 via-black/30 to-transparent p-4 pointer-events-none">
                        <template x-if="img.title">
                            <p x-text="img.title" class="text-white text-sm font-bold leading-snug"></p>
                        </template>
                        <template x-if="img.subtitle">
                            <p x-text="img.subtitle" class="text-white/80 text-xs mt-0.5"></p>
                        </template>
                        <template x-if="img.description">
                            <p x-text="img.description" class="text-white/70 text-xs mt-1 line-clamp-2"></p>
                        </template>
                    </div>
                </template>
            @endif
        </div>
    </template>

    {{-- Controles de navegação (múltiplas imagens) --}}
    <template x-if="images.length > 1">
        <div>
            <button
                @click.stop="prev()"
                aria-label="Imagem anterior"
                class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white rounded-full w-8 h-8 flex items-center justify-center opacity-0 group-hover:opacity-100 focus:opacity-100 transition-opacity duration-200 z-20 text-lg leading-none"
            >&#8249;</button>
            <button
                @click.stop="next()"
                aria-label="Próxima imagem"
                class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white rounded-full w-8 h-8 flex items-center justify-center opacity-0 group-hover:opacity-100 focus:opacity-100 transition-opacity duration-200 z-20 text-lg leading-none"
            >&#8250;</button>

            {{-- Indicadores --}}
            <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex items-center gap-1.5 z-20" role="tablist">
                <template x-for="(img, i) in images" :key="i">
                    <button
                        @click.stop="go(i)"
                        :aria-label="'Ir para imagem ' + (i + 1)"
                        :aria-selected="active === i"
                        role="tab"
                        :class="active === i ? 'bg-white w-4' : 'bg-white/50 hover:bg-white/80 w-1.5'"
                        class="h-1.5 rounded-full transition-all duration-300"
                    ></button>
                </template>
            </div>

            {{-- Contador --}}
            <div class="absolute top-2 right-2 bg-black/50 text-white text-xs px-2 py-0.5 rounded-full z-20">
                <span x-text="active + 1"></span>/<span x-text="images.length"></span>
            </div>
        </div>
    </template>

    {{-- Lightbox --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click.self="open = false"
        @touchstart.passive="handleTouchStart($event)"
        @touchend="handleTouchEnd($event)"
        class="fixed inset-0 bg-black/92 z-50 flex flex-col items-center justify-center"
        role="dialog"
        aria-modal="true"
        aria-label="Visualizador de imagens"
        style="display: none;"
    >
        <template x-for="(img, i) in images" :key="'lb-' + i">
            <div x-show="active === i" class="w-full h-full flex flex-col items-center justify-center">
                <img
                    :src="img.full"
                    :alt="img.alt || ''"
                    class="w-full h-full object-contain"
                >
                <template x-if="img.title || img.subtitle">
                    <div class="absolute bottom-16 left-1/2 -translate-x-1/2 text-center px-6 pointer-events-none">
                        <template x-if="img.title">
                            <p x-text="img.title" class="text-white font-bold text-base drop-shadow-lg"></p>
                        </template>
                        <template x-if="img.subtitle">
                            <p x-text="img.subtitle" class="text-white/70 text-sm mt-1 drop-shadow"></p>
                        </template>
                    </div>
                </template>
            </div>
        </template>

        {{-- Fechar --}}
        <button
            @click="open = false"
            aria-label="Fechar"
            class="absolute top-4 right-4 text-white/80 hover:text-white bg-white/10 hover:bg-white/20 rounded-full w-11 h-11 flex items-center justify-center transition text-2xl z-10"
        >&times;</button>

        {{-- Navegação no lightbox --}}
        <template x-if="images.length > 1">
            <div>
                <button
                    @click="prev()"
                    aria-label="Imagem anterior"
                    class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/10 hover:bg-white/25 text-white rounded-full w-12 h-12 flex items-center justify-center transition text-2xl z-10"
                >&#8249;</button>
                <button
                    @click="next()"
                    aria-label="Próxima imagem"
                    class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/10 hover:bg-white/25 text-white rounded-full w-12 h-12 flex items-center justify-center transition text-2xl z-10"
                >&#8250;</button>

                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 max-w-[80vw] overflow-x-auto pb-1 z-10">
                    <template x-for="(img, i) in images" :key="'th-' + i">
                        <button @click="go(i)" :aria-label="'Ver imagem ' + (i + 1)" class="shrink-0">
                            <img
                                :src="img.thumb"
                                :alt="img.alt || ''"
                                loading="lazy"
                                :class="active === i ? 'ring-2 ring-white opacity-100' : 'opacity-50 hover:opacity-80'"
                                class="w-14 h-10 object-cover rounded transition"
                            >
                        </button>
                    </template>
                </div>

                <div class="absolute top-4 left-1/2 -translate-x-1/2 bg-black/50 text-white text-sm px-3 py-1 rounded-full z-10">
                    <span x-text="active + 1"></span> / <span x-text="images.length"></span>
                </div>
            </div>
        </template>
    </div>
</div>
@endif
