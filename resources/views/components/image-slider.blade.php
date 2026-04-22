@props(['images', 'height' => 'h-52'])

@php
    $images = collect($images)->values();
@endphp

@if ($images->isNotEmpty())
    <div
        x-data="{
            active: 0,
            open: false,
            images: {{ $images->toJson() }},
            prev() { this.active = (this.active - 1 + this.images.length) % this.images.length },
            next() { this.active = (this.active + 1) % this.images.length },
        }"
        @keydown.escape.window="open = false"
        @keydown.arrow-left.window="if(open) prev()"
        @keydown.arrow-right.window="if(open) next()"
        class="relative w-full {{ $height }} rounded-lg overflow-hidden group cursor-zoom-in"
    >
        {{-- Slider --}}
        <template x-for="(img, i) in images" :key="i">
            <img
                :src="img.thumb"
                :alt="img.alt"
                x-show="active === i"
                @click="open = true"
                class="absolute inset-0 w-full h-full object-cover"
            >
        </template>

        {{-- Controles (múltiplas imagens) --}}
        <template x-if="images.length > 1">
            <div>
                <button
                    @click.stop="prev()"
                    class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white rounded-full w-8 h-8 flex items-center justify-center opacity-0 group-hover:opacity-100 transition z-10 text-lg leading-none"
                >&#8249;</button>
                <button
                    @click.stop="next()"
                    class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white rounded-full w-8 h-8 flex items-center justify-center opacity-0 group-hover:opacity-100 transition z-10 text-lg leading-none"
                >&#8250;</button>

                {{-- Indicadores --}}
                <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-1.5 z-10">
                    <template x-for="(img, i) in images" :key="i">
                        <button
                            @click.stop="active = i"
                            :class="active === i ? 'bg-white scale-110' : 'bg-white/40 hover:bg-white/70'"
                            class="w-1.5 h-1.5 rounded-full transition-all"
                        ></button>
                    </template>
                </div>

                {{-- Contador --}}
                <div class="absolute top-2 right-2 bg-black/50 text-white text-xs px-2 py-0.5 rounded-full z-10">
                    <span x-text="active + 1"></span>/<span x-text="images.length"></span>
                </div>
            </div>
        </template>

        {{-- Ícone de ampliar --}}
        <div class="absolute top-2 left-2 bg-black/40 text-white rounded-full w-7 h-7 flex items-center justify-center opacity-0 group-hover:opacity-100 transition z-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0zM11 8v6M8 11h6"/>
            </svg>
        </div>

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
            class="fixed inset-0 bg-black/90 z-50 flex items-center justify-center p-4"
            style="display: none;"
        >
            {{-- Imagem principal --}}
            <template x-for="(img, i) in images" :key="i">
                <img
                    :src="img.full"
                    :alt="img.alt"
                    x-show="active === i"
                    class="max-h-[85vh] max-w-[90vw] object-contain rounded-lg shadow-2xl"
                >
            </template>

            {{-- Fechar --}}
            <button
                @click="open = false"
                class="absolute top-4 right-4 text-white/80 hover:text-white bg-white/10 hover:bg-white/20 rounded-full w-10 h-10 flex items-center justify-center transition text-xl"
            >&times;</button>

            {{-- Navegação --}}
            <template x-if="images.length > 1">
                <div>
                    <button
                        @click="prev()"
                        class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/10 hover:bg-white/25 text-white rounded-full w-12 h-12 flex items-center justify-center transition text-2xl"
                    >&#8249;</button>
                    <button
                        @click="next()"
                        class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/10 hover:bg-white/25 text-white rounded-full w-12 h-12 flex items-center justify-center transition text-2xl"
                    >&#8250;</button>

                    {{-- Miniaturas --}}
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 max-w-[80vw] overflow-x-auto pb-1">
                        <template x-for="(img, i) in images" :key="i">
                            <button @click="active = i" class="shrink-0">
                                <img
                                    :src="img.thumb"
                                    :alt="img.alt"
                                    :class="active === i ? 'ring-2 ring-white opacity-100' : 'opacity-50 hover:opacity-80'"
                                    class="w-14 h-10 object-cover rounded transition"
                                >
                            </button>
                        </template>
                    </div>

                    {{-- Contador --}}
                    <div class="absolute top-4 left-1/2 -translate-x-1/2 bg-black/50 text-white text-sm px-3 py-1 rounded-full">
                        <span x-text="active + 1"></span> de <span x-text="images.length"></span>
                    </div>
                </div>
            </template>
        </div>
    </div>
@endif
