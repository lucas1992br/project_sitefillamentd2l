<?php

use App\Models\Client;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    #[Computed]
    public function clients(): Collection
    {
        return Client::active()->featured()->get();
    }
};
?>

<section id="clients" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">

        <p class="text-xs font-medium tracking-widest text-blue-500 uppercase mb-2">Trusted By</p>
        <h2 class="text-3xl font-medium text-blue-900 mb-12">Our Clients</h2>

        @if ($this->clients->isNotEmpty())
            {{-- Logos row --}}
            <div class="flex flex-wrap items-center justify-center gap-8 mb-14">
                @foreach ($this->clients as $client)
                    <div wire:key="logo-{{ $client->id }}">
                        @if ($client->getFirstMedia('logo'))
                            <img
                                src="{{ $client->getFirstMediaUrl('logo') }}"
                                alt="{{ $client->name }}"
                                class="h-10 object-contain grayscale hover:grayscale-0 transition"
                            >
                        @else
                            <span class="text-sm font-medium text-gray-400">{{ $client->name }}</span>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Testimonials --}}
            @php $testimonials = $this->clients->filter(fn ($c) => $c->testimonial); @endphp
            @if ($testimonials->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($testimonials as $client)
                        <x-card wire:key="testi-{{ $client->id }}" class="border border-blue-100">
                            <p class="text-sm text-gray-600 leading-relaxed italic mb-4">
                                &ldquo;{{ $client->testimonial }}&rdquo;
                            </p>
                            <div class="flex items-center gap-3">
                                @if ($client->getFirstMedia('logo'))
                                    <img
                                        src="{{ $client->getFirstMediaUrl('logo') }}"
                                        alt="{{ $client->name }}"
                                        class="w-8 h-8 object-contain"
                                    >
                                @endif
                                <div>
                                    <p class="text-xs font-semibold text-blue-900">
                                        {{ $client->contact_name ?? $client->name }}
                                    </p>
                                    @if ($client->contact_role)
                                        <p class="text-xs text-gray-400">{{ $client->contact_role }}, {{ $client->name }}</p>
                                    @endif
                                </div>
                            </div>
                        </x-card>
                    @endforeach
                </div>
            @endif
        @endif
    </div>
</section>
