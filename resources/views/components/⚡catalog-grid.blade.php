<?php

use App\Models\CatalogCategory;
use App\Models\CatalogItem;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    #[Url(as: 'categoria')]
    public string $category = '';

    public function updatedCategory(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function items(): LengthAwarePaginator
    {
        return CatalogItem::active()
            ->with(['category', 'media'])
            ->when($this->category, fn ($q) => $q->whereHas('category', fn ($q) => $q->where('slug', $this->category)))
            ->paginate(12);
    }

    #[Computed]
    public function categories(): Collection
    {
        return CatalogCategory::active()->get();
    }
};
?>

{{-- Lightbox global (Alpine.js) --}}
<div
    x-data="{
        open: false,
        images: [],
        current: 0,
        show(imgs, index) {
            this.images = imgs;
            this.current = index;
            this.open = true;
        },
        prev() { this.current = (this.current - 1 + this.images.length) % this.images.length; },
        next() { this.current = (this.current + 1) % this.images.length; },
        close() { this.open = false; }
    }"
    @keydown.escape.window="close()"
    @keydown.arrow-left.window="open && prev()"
    @keydown.arrow-right.window="open && next()"
>

    {{-- Filtro por categoria --}}
    @if ($this->categories->isNotEmpty())
        <div class="flex flex-wrap gap-2 mb-8">
            <button
                wire:click="$set('category', '')"
                class="px-4 py-1.5 rounded-full text-sm font-medium transition {{ $category === '' ? 'bg-blue-600 text-white' : 'bg-white text-blue-700 border border-blue-200 hover:border-blue-400' }}"
            >
                Todos
            </button>
            @foreach ($this->categories as $cat)
                <button
                    wire:click="$set('category', '{{ $cat->slug }}')"
                    class="px-4 py-1.5 rounded-full text-sm font-medium transition {{ $category === $cat->slug ? 'bg-blue-600 text-white' : 'bg-white text-blue-700 border border-blue-200 hover:border-blue-400' }}"
                >
                    {{ $cat->name }}
                </button>
            @endforeach
        </div>
    @endif

    {{-- Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse ($this->items as $item)
            @php
                $coverUrl  = $item->getFirstMediaUrl('cover', 'thumb');
                $coverFull = $item->getFirstMediaUrl('cover', 'full') ?: $coverUrl;
                $gallery   = $item->getMedia('gallery');

                // Monta array de todas as imagens (capa + galeria) para o lightbox
                $allImages = collect();
                if ($coverFull) {
                    $allImages->push(['url' => $coverFull, 'thumb' => $coverUrl, 'alt' => $item->title]);
                }
                foreach ($gallery as $media) {
                    $allImages->push([
                        'url'   => $media->getUrl('full') ?: $media->getUrl(),
                        'thumb' => $media->getUrl('thumb') ?: $media->getUrl(),
                        'alt'   => $item->title,
                    ]);
                }
                $imagesJson   = json_encode($allImages->values()->all());
                $galleryCount = $gallery->count();
            @endphp

            <div wire:key="{{ $item->id }}" class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-md hover:border-blue-200 transition-all duration-300 flex flex-col">

                {{-- Imagem de capa clicável --}}
                @if ($coverUrl)
                    <button
                        type="button"
                        class="relative group block w-full shrink-0 overflow-hidden"
                        @click="show({{ $imagesJson }}, 0)"
                    >
                        <img
                            src="{{ $coverUrl }}"
                            alt="{{ $item->title }}"
                            class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-500"
                        >
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition flex items-center justify-center">
                            <x-icon name="magnifying-glass-plus" class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition" />
                        </div>
                        @if ($galleryCount > 0)
                            <span class="absolute bottom-2 right-2 inline-flex items-center gap-1 bg-black/60 text-white text-xs px-2 py-0.5 rounded-full">
                                <x-icon name="photo" class="w-3 h-3" />
                                {{ $galleryCount + 1 }}
                            </span>
                        @endif
                    </button>
                @else
                    <div class="w-full h-44 bg-slate-50 flex items-center justify-center border-b border-slate-100 shrink-0">
                        <x-icon name="photo" class="w-10 h-10 text-slate-200" />
                    </div>
                @endif

                {{-- Conteúdo --}}
                <div class="p-4 flex flex-col gap-1.5 flex-1">
                    <div class="flex items-start justify-between gap-2">
                        <h3 class="text-sm font-semibold text-blue-900 leading-snug">{{ $item->title }}</h3>
                        @if ($item->is_featured)
                            <x-badge color="warning" text="Destaque" />
                        @endif
                    </div>

                    @if ($item->category)
                        <x-badge color="primary" :text="$item->category->name" />
                    @endif

                    @if ($item->reference)
                        <p class="text-xs text-gray-400">Ref: {{ $item->reference }}</p>
                    @endif

                    @if ($item->description)
                        <p class="text-sm text-gray-500 leading-relaxed line-clamp-3 mt-1">
                            {!! strip_tags($item->description) !!}
                        </p>
                    @endif

                    {{-- Miniaturas da galeria --}}
                    @if ($galleryCount > 0)
                        <div class="flex gap-1.5 mt-2 flex-wrap">
                            @foreach ($gallery->take(4) as $index => $media)
                                <button
                                    type="button"
                                    class="w-12 h-12 rounded-lg overflow-hidden border border-slate-200 hover:border-blue-400 transition shrink-0"
                                    @click="show({{ $imagesJson }}, {{ $index + 1 }})"
                                >
                                    <img
                                        src="{{ $media->getUrl('thumb') ?: $media->getUrl() }}"
                                        alt="{{ $item->title }}"
                                        class="w-full h-full object-cover"
                                    >
                                </button>
                            @endforeach
                            @if ($galleryCount > 4)
                                <button
                                    type="button"
                                    class="w-12 h-12 rounded-lg bg-slate-100 border border-slate-200 hover:border-blue-400 flex items-center justify-center text-xs font-semibold text-slate-500 transition shrink-0"
                                    @click="show({{ $imagesJson }}, 5)"
                                >
                                    +{{ $galleryCount - 4 }}
                                </button>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16 text-gray-400 text-sm">
                Nenhum item encontrado no catálogo.
            </div>
        @endforelse
    </div>

    {{-- Paginação --}}
    @if ($this->items->hasPages())
        <div class="mt-10">
            {{ $this->items->links() }}
        </div>
    @endif

    {{-- Lightbox --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-4"
        @click.self="close()"
        style="display: none;"
    >
        {{-- Botão fechar --}}
        <button
            type="button"
            @click="close()"
            class="absolute top-4 right-4 text-white/70 hover:text-white transition z-10"
        >
            <x-icon name="x-mark" class="w-8 h-8" />
        </button>

        {{-- Contador --}}
        <div class="absolute top-4 left-1/2 -translate-x-1/2 text-white/60 text-sm z-10">
            <span x-text="current + 1"></span> / <span x-text="images.length"></span>
        </div>

        {{-- Seta anterior --}}
        <button
            type="button"
            @click="prev()"
            x-show="images.length > 1"
            class="absolute left-3 md:left-6 text-white/70 hover:text-white transition z-10 p-2"
        >
            <x-icon name="chevron-left" class="w-8 h-8" />
        </button>

        {{-- Imagem principal --}}
        <div class="max-w-4xl w-full max-h-[80vh] flex items-center justify-center">
            <template x-for="(img, i) in images" :key="i">
                <img
                    x-show="current === i"
                    :src="img.url"
                    :alt="img.alt"
                    class="max-w-full max-h-[80vh] object-contain rounded-xl shadow-2xl"
                >
            </template>
        </div>

        {{-- Seta próxima --}}
        <button
            type="button"
            @click="next()"
            x-show="images.length > 1"
            class="absolute right-3 md:right-6 text-white/70 hover:text-white transition z-10 p-2"
        >
            <x-icon name="chevron-right" class="w-8 h-8" />
        </button>

        {{-- Tira de miniaturas --}}
        <div
            x-show="images.length > 1"
            class="absolute bottom-4 left-0 right-0 flex justify-center gap-2 px-4 overflow-x-auto"
        >
            <template x-for="(img, i) in images" :key="i">
                <button
                    type="button"
                    @click="current = i"
                    class="shrink-0 w-12 h-12 rounded-lg overflow-hidden border-2 transition"
                    :class="current === i ? 'border-blue-400' : 'border-white/20 opacity-60 hover:opacity-100'"
                >
                    <img :src="img.thumb" :alt="img.alt" class="w-full h-full object-cover">
                </button>
            </template>
        </div>
    </div>
</div>
