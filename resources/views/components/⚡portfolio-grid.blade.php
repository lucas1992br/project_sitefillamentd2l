<?php

use App\Models\PortfolioItem;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    #[Url(as: 'category')]
    public string $category = '';

    public function updatedCategory(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function items(): LengthAwarePaginator
    {
        return PortfolioItem::active()
            ->with('media')
            ->when($this->category, fn ($q) => $q->where('category', $this->category))
            ->paginate(9);
    }

    #[Computed]
    public function categories(): Collection
    {
        return PortfolioItem::query()
            ->where('is_active', true)
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->filter();
    }
};
?>

<div>
    {{-- Category filter --}}
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
                    wire:click="$set('category', '{{ $cat }}')"
                    class="px-4 py-1.5 rounded-lg text-sm font-bold transition {{ $category === $cat ? 'bg-[#0066cc] text-white' : 'bg-white text-[#414753] border border-[#e1e2eb] hover:border-[#0066cc] hover:text-[#0066cc]' }}"
                >
                    {{ ucfirst($cat) }}
                </button>
            @endforeach
        </div>
    @endif

    {{-- Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($this->items as $item)
            @php
                $images = collect();
                $cover = $item->getFirstMedia('cover');
                if ($cover) {
                    $images->push([
                        'thumb' => $cover->hasGeneratedConversion('thumb') ? $cover->getUrl('thumb') : $cover->getUrl(),
                        'full'  => $cover->getUrl(),
                        'alt'   => td($item->title),
                    ]);
                }
                foreach ($item->getMedia('gallery') as $media) {
                    $images->push([
                        'thumb' => $media->hasGeneratedConversion('thumb') ? $media->getUrl('thumb') : $media->getUrl(),
                        'full'  => $media->getUrl(),
                        'alt'   => td($item->title),
                    ]);
                }
            @endphp
            <div wire:key="{{ $item->id }}" class="group bg-white rounded-xl border border-[#e1e2eb] overflow-hidden il-card-hover transition-all duration-300 hover:-translate-y-1 flex flex-col">

                @if ($images->isNotEmpty())
                    <x-image-slider :images="$images" height="h-48" />
                @else
                    <div class="w-full h-48 bg-[#ecedf6] flex items-center justify-center">
                        <x-icon name="photo" class="w-10 h-10 text-[#c1c6d5]" />
                    </div>
                @endif

                <div class="p-5 flex flex-col gap-2 flex-1">
                    <div class="flex items-start justify-between gap-2">
                        <h3 class="text-sm font-bold text-[#191c22] group-hover:text-[#0066cc] transition-colors leading-snug">{{ td($item->title) }}</h3>
                        @if ($item->is_featured)
                            <span class="shrink-0 text-[10px] font-bold text-amber-600 bg-amber-50 border border-amber-100 px-2 py-0.5 rounded-full uppercase tracking-wider">{{ __('site.common.featured') }}</span>
                        @endif
                    </div>

                    @if ($item->category)
                        <span class="inline-block w-fit text-xs font-bold text-[#0066cc] bg-[#d7e3ff] border border-[#aac7ff] px-2 py-0.5 rounded-full">{{ ucfirst($item->category) }}</span>
                    @endif

                    @if ($item->material)
                        <p class="text-xs text-[#727784]">{{ __('site.common.material') }}: {{ $item->material }}</p>
                    @endif

                    @if ($item->description)
                        <p class="text-sm text-[#414753] leading-relaxed line-clamp-3 mt-auto">
                            {!! td(strip_tags($item->description)) !!}
                        </p>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16 text-[#727784] text-sm">
                {{ __('site.common.no_portfolio') }}
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if ($this->items->hasPages())
        <div class="mt-10">
            {{ $this->items->links() }}
        </div>
    @endif
</div>
