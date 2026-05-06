@extends('layouts.site')

@section('title', __('site.certifications.title') . ' — ' . config('app.name'))
@section('description', __('site.certifications.description'))

@section('content')

    {{-- Page header --}}
    <section class="py-16 bg-[#f9f9ff] border-b border-[#e1e2eb]">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <p class="text-xs font-bold tracking-widest text-[#0066cc] uppercase mb-3">{{ __('site.certifications.tag') }}</p>
            <h1 class="text-4xl md:text-5xl font-bold text-[#191c22] tracking-tight mb-4">{{ __('site.certifications.title') }}</h1>
            <p class="text-[#414753] max-w-xl leading-relaxed text-lg">{{ __('site.certifications.description') }}</p>
        </div>
    </section>

    <section
        class="py-20 bg-white"
        x-data="{
            open: false,
            cert: {},
            show(c) { this.cert = c; this.open = true; }
        }"
        @keydown.escape.window="open = false"
    >
        <div class="max-w-7xl mx-auto px-6 md:px-12">

            @if($certifications->isEmpty())
                <div class="text-center py-24">
                    <x-icon name="shield-check" class="w-12 h-12 text-[#c1c6d5] mx-auto mb-4" />
                    <p class="text-[#727784] text-sm">{{ __('site.certifications.empty') }}</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($certifications as $cert)
                        @php
                            $certData = [
                                'name'               => td($cert->name),
                                'issuer'             => $cert->issuer,
                                'certificate_number' => $cert->certificate_number,
                                'issued_at'          => $cert->issued_at?->format('d/m/Y'),
                                'expires_at'         => $cert->expires_at?->format('d/m/Y'),
                                'description'        => td((string) $cert->description),
                                'is_expired'         => $cert->isExpired(),
                                'logo_url'           => $cert->getFirstMediaUrl('logo'),
                                'cert_url'           => $cert->getFirstMediaUrl('certificate'),
                                'cert_mime'          => $cert->getFirstMedia('certificate')?->mime_type,
                            ];
                        @endphp
                        <button
                            type="button"
                            @click="show({{ json_encode($certData) }})"
                            class="group bg-white rounded-xl border border-[#e1e2eb] p-6 il-card-hover transition-all duration-300 text-left w-full cursor-pointer hover:-translate-y-1"
                        >
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-12 h-12 rounded-xl bg-[#d7e3ff] flex items-center justify-center shrink-0 group-hover:bg-[#0066cc] transition-colors duration-300">
                                    @if($cert->getFirstMedia('logo'))
                                        <img src="{{ $cert->getFirstMediaUrl('logo') }}" alt="{{ td($cert->name) }}" class="w-8 h-8 object-contain">
                                    @else
                                        <x-icon name="shield-check" class="w-6 h-6 text-[#0066cc] group-hover:text-white transition-colors duration-300" />
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-[#191c22] group-hover:text-[#0066cc] transition-colors truncate">{{ td($cert->name) }}</p>
                                    <p class="text-xs text-[#727784]">{{ $cert->issuer }}</p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                @if($cert->issued_at)
                                    <p class="text-xs text-[#727784]">{{ __('site.certifications.issued') }}: {{ $cert->issued_at->format('d/m/Y') }}</p>
                                @endif
                                @if(!$cert->isExpired() && $cert->expires_at)
                                    <span class="text-xs font-bold text-green-600 bg-green-50 border border-green-100 px-2 py-0.5 rounded-full">{{ __('site.certifications.valid') }}</span>
                                @elseif($cert->isExpired())
                                    <span class="text-xs font-bold text-red-500 bg-red-50 border border-red-100 px-2 py-0.5 rounded-full">{{ __('site.certifications.expired') }}</span>
                                @endif
                            </div>

                            <p class="text-xs text-[#0066cc] mt-3 group-hover:text-[#004e9f] transition-colors flex items-center gap-1">
                                <x-icon name="eye" class="w-3.5 h-3.5" /> {{ __('site.certifications.see_details') }}
                            </p>
                        </button>
                    @endforeach
                </div>
            @endif

        </div>

        {{-- Modal --}}
        <div
            x-show="open"
            x-transition:enter="transition duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition duration-150"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
            @click.self="open = false"
            style="display:none"
        >
            <div
                x-show="open"
                x-transition:enter="transition duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition duration-150"
                x-transition:leave-end="opacity-0 scale-95"
                class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden border border-[#e1e2eb]"
            >
                <div class="flex items-center justify-between px-6 py-4 border-b border-[#e1e2eb]">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-[#d7e3ff] flex items-center justify-center shrink-0">
                            <template x-if="cert.logo_url">
                                <img :src="cert.logo_url" :alt="cert.name" class="w-6 h-6 object-contain">
                            </template>
                            <template x-if="!cert.logo_url">
                                <x-icon name="shield-check" class="w-5 h-5 text-[#0066cc]" />
                            </template>
                        </div>
                        <h3 x-text="cert.name" class="text-base font-bold text-[#191c22]"></h3>
                    </div>
                    <button @click="open = false" class="text-[#727784] hover:text-[#191c22] transition">
                        <x-icon name="x-mark" class="w-5 h-5" />
                    </button>
                </div>

                <div class="px-6 py-5 space-y-4">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-xs text-[#727784] mb-0.5 uppercase tracking-wider">{{ __('site.certifications.issuer') }}</p>
                            <p class="font-semibold text-[#191c22]" x-text="cert.issuer"></p>
                        </div>
                        <template x-if="cert.certificate_number">
                            <div>
                                <p class="text-xs text-[#727784] mb-0.5 uppercase tracking-wider">{{ __('site.certifications.number') }}</p>
                                <p class="font-semibold text-[#191c22]" x-text="cert.certificate_number"></p>
                            </div>
                        </template>
                        <template x-if="cert.issued_at">
                            <div>
                                <p class="text-xs text-[#727784] mb-0.5 uppercase tracking-wider">{{ __('site.certifications.issued_at') }}</p>
                                <p class="font-semibold text-[#191c22]" x-text="cert.issued_at"></p>
                            </div>
                        </template>
                        <template x-if="cert.expires_at">
                            <div>
                                <p class="text-xs text-[#727784] mb-0.5 uppercase tracking-wider">{{ __('site.certifications.expires_at') }}</p>
                                <p class="font-semibold" :class="cert.is_expired ? 'text-red-500' : 'text-green-600'" x-text="cert.expires_at + (cert.is_expired ? ' {{ __('site.certifications.expired_label') }}' : ' {{ __('site.certifications.valid_label') }}')"></p>
                            </div>
                        </template>
                    </div>

                    <template x-if="cert.description">
                        <div>
                            <p class="text-xs text-[#727784] mb-1 uppercase tracking-wider">{{ __('site.certifications.description_label') }}</p>
                            <p class="text-sm text-[#414753] leading-relaxed" x-text="cert.description"></p>
                        </div>
                    </template>

                    <template x-if="cert.cert_url">
                        <div>
                            <p class="text-xs text-[#727784] mb-2 uppercase tracking-wider">{{ __('site.certifications.document') }}</p>
                            <template x-if="cert.cert_mime && cert.cert_mime.startsWith('image/')">
                                <img :src="cert.cert_url" alt="Certificado" class="w-full rounded-lg border border-[#e1e2eb] object-contain max-h-64">
                            </template>
                            <template x-if="!cert.cert_mime || !cert.cert_mime.startsWith('image/')">
                                <a :href="cert.cert_url" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[#d7e3ff] border border-[#aac7ff] text-[#004e9f] text-sm font-bold hover:bg-[#aac7ff] transition">
                                    <x-icon name="document-arrow-down" class="w-4 h-4" />
                                    {{ __('site.certifications.view_pdf') }}
                                </a>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </section>

@endsection
