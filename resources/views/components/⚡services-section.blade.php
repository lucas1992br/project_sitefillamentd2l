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
        return Service::active()->with('media')->take(4)->get();
    }
};
?>

<section id="services" class="py-24 bg-[#f9f9ff] border-t border-[#e1e2eb]">
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
            @foreach ($this->services as $service)
                <a wire:key="{{ $service->id }}"
                   href="{{ route('services.index') }}"
                   class="group flex flex-col bg-white rounded-xl border border-[#e1e2eb] overflow-hidden il-card-hover transition-all duration-300 hover:-translate-y-1">

                    @if ($service->getFirstMedia('cover'))
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
                        @if ($service->subtitle)
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
