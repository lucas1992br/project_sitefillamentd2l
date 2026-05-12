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

<div>
    {{-- Filtro por categoria --}}
    @if ($this->categories->isNotEmpty())
        <div class="flex flex-wrap gap-2 mb-8">
            <button
                wire:click="$set('category', '')"
                class="px-4 py-1.5 rounded-lg text-sm font-bold transition {{ $category === '' ? 'bg-[#0066cc] text-white' : 'bg-white text-[#414753] border border-[#e1e2eb] hover:border-[#0066cc] hover:text-[#0066cc]' }}"
            >
                {{ __('site.common.all') }}
            </button>
            @foreach ($this->categories as $cat)
                <button
                    wire:click="$set('category', '{{ $cat->slug }}')"
                    class="px-4 py-1.5 rounded-lg text-sm font-bold transition {{ $category === $cat->slug ? 'bg-[#0066cc] text-white' : 'bg-white text-[#414753] border border-[#e1e2eb] hover:border-[#0066cc] hover:text-[#0066cc]' }}"
                >
                    {{ td($cat->name) }}
                </button>
            @endforeach
        </div>
    @endif

    {{-- Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse ($this->items as $item)
            @php
                $images    = collect();
                $itemTitle = td($item->title);
                $itemSub   = $item->subtitle ? td($item->subtitle) : ($item->reference ? 'Ref: ' . $item->reference : null);
                $cover     = $item->getFirstMedia('cover');
                if ($cover) {
                    $images->push([
                        'thumb'    => $cover->hasGeneratedConversion('thumb') ? $cover->getUrl('thumb') : $cover->getUrl(),
                        'full'     => $cover->getUrl(),
                        'alt'      => $itemTitle,
                        'title'    => $itemTitle,
                        'subtitle' => $itemSub,
                    ]);
                }
                foreach ($item->getMedia('gallery') as $media) {
                    $images->push([
                        'thumb'    => $media->hasGeneratedConversion('thumb') ? $media->getUrl('thumb') : $media->getUrl(),
                        'full'     => $media->getUrl(),
                        'alt'      => $itemTitle,
                        'title'    => $itemTitle,
                        'subtitle' => $itemSub,
                    ]);
                }
            @endphp

            <div wire:key="{{ $item->id }}" class="group bg-white rounded-xl border border-[#e1e2eb] overflow-hidden il-card-hover transition-all duration-300 hover:-translate-y-1 flex flex-col">

                <x-image-gallery :images="$images" height="h-48" />

                {{-- Conteúdo --}}
                <div class="p-4 flex flex-col gap-1.5 flex-1">
                    <div class="flex items-start justify-between gap-2">
                        <h3 class="text-sm font-bold text-[#191c22] leading-snug group-hover:text-[#0066cc] transition-colors">{{ td($item->title) }}</h3>
                        @if ($item->is_featured)
                            <x-badge color="warning" :text="__('site.common.featured')" />
                        @endif
                    </div>

                    @if ($item->category)
                        <x-badge color="primary" :text="td($item->category->name)" />
                    @endif

                    @if ($item->reference)
                        <p class="text-xs text-[#727784]">{{ __('site.common.ref') }}: {{ $item->reference }}</p>
                    @endif

                    @if ($item->description)
                        <p class="text-sm text-[#414753] leading-relaxed line-clamp-3 mt-1">
                            {!! td(strip_tags($item->description)) !!}
                        </p>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16 text-[#727784] text-sm">
                {{ __('site.common.no_catalog') }}
            </div>
        @endforelse
    </div>

    {{-- Paginação --}}
    @if ($this->items->hasPages())
        <div class="mt-10">
            {{ $this->items->links() }}
        </div>
    @endif
</div>
