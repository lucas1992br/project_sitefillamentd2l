<?php

use App\Models\Certification;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    #[Computed]
    public function certifications(): Collection
    {
        return Certification::active()->get();
    }
};
?>

<section id="certifications" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">

        <p class="text-xs font-medium tracking-widest text-blue-500 uppercase mb-2">Qualidade</p>
        <h2 class="text-3xl font-medium text-blue-900 mb-12">Nossas Certificações</h2>    

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($this->certifications as $cert)
                <x-card wire:key="{{ $cert->id }}" class="border border-blue-100 hover:shadow-md transition">
                    <div class="flex items-center gap-4 mb-4">
                        @if ($cert->getFirstMedia('logo'))
                            <img
                                src="{{ $cert->getFirstMediaUrl('logo') }}"
                                alt="{{ $cert->name }}"
                                class="w-14 h-14 object-contain"
                            >
                        @else
                            <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center">
                                <x-icon name="shield-check" class="w-7 h-7 text-blue-600" />
                            </div>
                        @endif

                        <div>
                            <h3 class="text-sm font-semibold text-blue-900">{{ $cert->name }}</h3>
                            <p class="text-xs text-gray-500">{{ $cert->issuer }}</p>
                        </div>
                    </div>

                    @if ($cert->certificate_number)
                        <p class="text-xs text-gray-400 mb-1">Cert #{{ $cert->certificate_number }}</p>
                    @endif

                    <div class="flex items-center justify-between mt-3">
                        <div class="text-xs text-gray-500">
                            @if ($cert->issued_at)
                                Emitido em: {{ $cert->issued_at->format('M Y') }}
                            @endif
                        </div>
                        @if ($cert->expires_at)
                            @if ($cert->isExpired())
                                <x-badge color="danger" text="Expirado" />
                            @else
                                <x-badge color="success" text="Válido até {{ $cert->expires_at->format('M Y') }}" />
                            @endif
                        @else
                            <x-badge color="success" text="Sem expiração" />
                        @endif
                    </div>

                    @if ($cert->getFirstMedia('certificate'))
                        <div class="mt-4">
                            <a
                                href="{{ $cert->getFirstMediaUrl('certificate') }}"
                                target="_blank"
                                class="inline-flex items-center gap-1 text-xs text-blue-600 hover:text-blue-800 transition"
                            >
                                <x-icon name="document-arrow-down" class="w-4 h-4" />
                                Ver Certificado
                            </a>
                        </div>
                    @endif
                </x-card>
            @empty
                <div class="col-span-full text-center py-16 text-gray-400 text-sm">
                    Nenhuma certificação listada ainda.
                </div>
            @endforelse
        </div>
    </div>
</section>
