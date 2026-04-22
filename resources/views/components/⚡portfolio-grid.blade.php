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
                class="px-4 py-1.5 rounded-full text-sm font-medium transition {{ $category === '' ? 'bg-blue-600 text-white' : 'bg-white text-blue-700 border border-blue-200 hover:border-blue-400' }}"
            >
                All
            </button>
            @foreach ($this->categories as $cat)
                <button
                    wire:click="$set('category', '{{ $cat }}')"
                    class="px-4 py-1.5 rounded-full text-sm font-medium transition {{ $category === $cat ? 'bg-blue-600 text-white' : 'bg-white text-blue-700 border border-blue-200 hover:border-blue-400' }}"
                >
                    {{ ucfirst($cat) }}
                </button>
            @endforeach
        </div>
    @endif

    {{-- Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($this->items as $item)
            <x-card wire:key="{{ $item->id }}" class="overflow-hidden hover:shadow-md transition">
                @php
                    $images = collect();
                    $cover = $item->getFirstMedia('cover');
                    if ($cover) {
                        $images->push([
                            'thumb' => $cover->hasGeneratedConversion('thumb') ? $cover->getUrl('thumb') : $cover->getUrl(),
                            'full'  => $cover->getUrl(),
                            'alt'   => $item->title,
                        ]);
                    }
                    foreach ($item->getMedia('gallery') as $media) {
                        $images->push([
                            'thumb' => $media->hasGeneratedConversion('thumb') ? $media->getUrl('thumb') : $media->getUrl(),
                            'full'  => $media->getUrl(),
                            'alt'   => $item->title,
                        ]);
                    }
                @endphp
                @if ($images->isNotEmpty())
                    <x-image-slider :images="$images" height="h-48" class="mb-4" />
                @endif

                <div class="flex items-start justify-between gap-2 mb-2">
                    <h3 class="text-sm font-semibold text-blue-900">{{ $item->title }}</h3>
                    @if ($item->is_featured)
                        <x-badge color="warning" text="Featured" />
                    @endif
                </div>

                @if ($item->category)
                    <x-badge color="primary" :text="ucfirst($item->category)" class="mb-2" />
                @endif

                @if ($item->material)
                    <p class="text-xs text-gray-400 mb-2">Material: {{ $item->material }}</p>
                @endif

                <p class="text-sm text-gray-500 leading-relaxed line-clamp-3">
                    {!! strip_tags($item->description) !!}
                </p>
            </x-card>
        @empty
            <div class="col-span-full text-center py-16 text-gray-400 text-sm">
                No portfolio items found.
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
