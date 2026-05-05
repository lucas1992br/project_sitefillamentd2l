@extends('layouts.site')

@section('title', __('site.certifications.title') . ' — ' . config('app.name'))
@section('description', __('site.certifications.description'))

@section('content')

    <section class="bg-slate-950 text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-tech-grid opacity-40 pointer-events-none"></div>
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-blue-500/40 to-transparent"></div>
        <div class="relative max-w-7xl mx-auto px-6">
            <p class="text-xs font-semibold tracking-widest text-blue-400 uppercase mb-3">{{ __('site.certifications.tag') }}</p>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ __('site.certifications.title') }}</h1>
            <p class="text-blue-200/70 max-w-xl leading-relaxed">
                {{ __('site.certifications.description') }}
            </p>
        </div>
    </section>

    <section
        class="py-20 bg-slate-50"
        x-data="{
            open: false,
            cert: {},
            show(c) { this.cert = c; this.open = true; }
        }"
        @keydown.escape.window="open = false"
    >
        <div class="max-w-7xl mx-auto px-6">

            @if($certifications->isEmpty())
                <div class="text-center py-24">
                    <x-icon name="shield-check" class="w-12 h-12 text-slate-300 mx-auto mb-4" />
                    <p class="text-slate-400 text-sm">{{ __('site.certifications.empty') }}</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($certifications as $cert)
                        @php
                            $certData = [
                                'name'               => $cert->name,
                                'issuer'             => $cert->issuer,
                                'certificate_number' => $cert->certificate_number,
                                'issued_at'          => $cert->issued_at?->format('d/m/Y'),
                                'expires_at'         => $cert->expires_at?->format('d/m/Y'),
                                'description'        => $cert->description,
                                'is_expired'         => $cert->isExpired(),
                                'logo_url'           => $cert->getFirstMediaUrl('logo'),
                                'cert_url'           => $cert->getFirstMediaUrl('certificate'),
                                'cert_mime'          => $cert->getFirstMedia('certificate')?->mime_type,
                            ];
                        @endphp
                        <button
                            type="button"
                            @click="show({{ json_encode($certData) }})"
                            class="group bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:border-blue-200 hover:shadow-md transition-all duration-300 text-left w-full cursor-pointer"
                        >
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center shrink-0 group-hover:bg-blue-500 transition-colors duration-300">
                                    @if($cert->getFirstMedia('logo'))
                                        <img src="{{ $cert->getFirstMediaUrl('logo') }}" alt="{{ $cert->name }}" class="w-8 h-8 object-contain">
                                    @else
                                        <x-icon name="shield-check" class="w-6 h-6 text-blue-500 group-hover:text-white transition-colors duration-300" />
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-slate-900 group-hover:text-blue-600 transition-colors truncate">{{ $cert->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $cert->issuer }}</p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                @if($cert->issued_at)
                                    <p class="text-xs text-slate-400">{{ __('site.certifications.issued') }}: {{ $cert->issued_at->format('d/m/Y') }}</p>
                                @endif
                                @if(!$cert->isExpired() && $cert->expires_at)
                                    <span class="text-xs font-semibold text-green-600 bg-green-50 border border-green-100 px-2 py-0.5 rounded-full">{{ __('site.certifications.valid') }}</span>
                                @elseif($cert->isExpired())
                                    <span class="text-xs font-semibold text-red-500 bg-red-50 border border-red-100 px-2 py-0.5 rounded-full">{{ __('site.certifications.expired') }}</span>
                                @endif
                            </div>

                            <p class="text-xs text-blue-400 mt-3 group-hover:text-blue-600 transition-colors flex items-center gap-1">
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
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
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
                class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden"
            >
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-blue-50 flex items-center justify-center shrink-0">
                            <template x-if="cert.logo_url">
                                <img :src="cert.logo_url" :alt="cert.name" class="w-6 h-6 object-contain">
                            </template>
                            <template x-if="!cert.logo_url">
                                <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.955 11.955 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
                            </template>
                        </div>
                        <h3 x-text="cert.name" class="text-base font-bold text-slate-900"></h3>
                    </div>
                    <button @click="open = false" class="text-slate-400 hover:text-slate-600 transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <div class="px-6 py-5 space-y-4">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">{{ __('site.certifications.issuer') }}</p>
                            <p class="font-medium text-slate-800" x-text="cert.issuer"></p>
                        </div>
                        <template x-if="cert.certificate_number">
                            <div>
                                <p class="text-xs text-slate-400 mb-0.5">{{ __('site.certifications.number') }}</p>
                                <p class="font-medium text-slate-800" x-text="cert.certificate_number"></p>
                            </div>
                        </template>
                        <template x-if="cert.issued_at">
                            <div>
                                <p class="text-xs text-slate-400 mb-0.5">{{ __('site.certifications.issued_at') }}</p>
                                <p class="font-medium text-slate-800" x-text="cert.issued_at"></p>
                            </div>
                        </template>
                        <template x-if="cert.expires_at">
                            <div>
                                <p class="text-xs text-slate-400 mb-0.5">{{ __('site.certifications.expires_at') }}</p>
                                <p class="font-medium" :class="cert.is_expired ? 'text-red-500' : 'text-green-600'" x-text="cert.expires_at + (cert.is_expired ? ' {{ __('site.certifications.expired_label') }}' : ' {{ __('site.certifications.valid_label') }}')"></p>
                            </div>
                        </template>
                    </div>

                    <template x-if="cert.description">
                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">{{ __('site.certifications.description_label') }}</p>
                            <p class="text-sm text-slate-600 leading-relaxed" x-text="cert.description"></p>
                        </div>
                    </template>

                    <template x-if="cert.cert_url">
                        <div>
                            <p class="text-xs text-slate-400 mb-2">{{ __('site.certifications.document') }}</p>
                            <template x-if="cert.cert_mime && cert.cert_mime.startsWith('image/')">
                                <img :src="cert.cert_url" alt="Certificado" class="w-full rounded-lg border border-slate-100 object-contain max-h-64">
                            </template>
                            <template x-if="!cert.cert_mime || !cert.cert_mime.startsWith('image/')">
                                <a :href="cert.cert_url" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-50 border border-blue-100 text-blue-600 text-sm font-medium hover:bg-blue-100 transition">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
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
