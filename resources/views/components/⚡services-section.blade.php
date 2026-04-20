<?php

use App\Models\Service;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    #[Computed]
    public function services(): Collection
    {
        return Service::active()->take(4)->get();
    }
};
?>

<section id="services" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">

        <p class="text-xs font-medium tracking-widest text-blue-500 uppercase mb-2">Our Services</p>
        <h2 class="text-3xl font-medium text-blue-900 mb-12">Complete industrial capability</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($this->services as $service)
                <x-card wire:key="{{ $service->id }}" class="border border-blue-100 border-t-4 border-t-blue-500 hover:shadow-md transition">
                    @if ($service->getFirstMedia('cover'))
                        <img src="{{ $service->getFirstMediaUrl('cover', 'thumb') }}"
                             alt="{{ $service->title }}"
                             class="w-full h-36 object-cover rounded-lg mb-4">
                    @endif

                    <h3 class="text-sm font-medium text-blue-900 mb-1">{{ $service->title }}</h3>

                    @if ($service->subtitle)
                        <x-badge color="primary" :text="$service->subtitle" class="mb-3" />
                    @endif

                    <p class="text-sm text-gray-500 leading-relaxed line-clamp-3">
                        {!! strip_tags($service->description) !!}
                    </p>
                </x-card>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <x-button
                href="{{ route('services.index') }}"
                color="primary"
                text="View all services"
                outline
                class="rounded-full px-8"
            />
        </div>
    </div>
</section>