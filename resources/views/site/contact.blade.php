@extends('layouts.site')

@section('title', __('site.contact.page_title') . ' — ' . config('app.name'))
@section('description', __('site.contact.page_desc'))

@section('content')

<section class="py-24 bg-[#004e9f] relative overflow-hidden min-h-[80vh] flex items-center">

    <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-[600px] h-[600px] rounded-full bg-white/5 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] rounded-full bg-[#0066cc]/30 blur-3xl pointer-events-none"></div>

    <div class="relative w-full max-w-7xl mx-auto px-6 md:px-12">

        <div class="text-center mb-14">
            <p class="text-xs font-bold tracking-widest text-[#aac7ff] uppercase mb-2">{{ __('site.contact.tag') }}</p>
            <h1 class="text-4xl md:text-5xl font-bold text-white tracking-tight mb-3">{{ __('site.contact.heading') }}</h1>
            <p class="text-[#aac7ff] text-lg max-w-xl mx-auto leading-relaxed">{{ __('site.contact.subheading') }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            {{-- Informações de contato --}}
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20">
                    <h2 class="text-xs font-bold uppercase tracking-widest text-[#aac7ff] mb-5">{{ __('site.contact.info_title') }}</h2>
                    <ul class="space-y-4">
                        @if($siteContent->contact_email)
                        <li class="flex items-start gap-4 p-4 rounded-lg bg-white/5 border border-white/10 hover:border-white/30 transition-colors">
                            <x-icon name="envelope" class="w-5 h-5 text-white mt-0.5 shrink-0" />
                            <div>
                                <p class="text-xs text-[#aac7ff] mb-0.5">{{ __('site.contact.email') }}</p>
                                <a href="mailto:{{ $siteContent->contact_email }}" class="text-sm font-semibold text-white hover:text-[#d7e3ff] transition">{{ $siteContent->contact_email }}</a>
                            </div>
                        </li>
                        @endif

                        @if($siteContent->phone)
                        <li class="flex items-start gap-4 p-4 rounded-lg bg-white/5 border border-white/10 hover:border-white/30 transition-colors">
                            <x-icon name="phone" class="w-5 h-5 text-white mt-0.5 shrink-0" />
                            <div>
                                <p class="text-xs text-[#aac7ff] mb-0.5">{{ __('site.contact.phone') }}</p>
                                <a href="tel:{{ preg_replace('/\D/', '', $siteContent->phone) }}" class="text-sm font-semibold text-white hover:text-[#d7e3ff] transition">{{ $siteContent->phone }}</a>
                            </div>
                        </li>
                        @endif

                        @if($siteContent->whatsapp_url)
                        <li class="flex items-start gap-4 p-4 rounded-lg bg-white/5 border border-white/10 hover:border-white/30 transition-colors">
                            <x-icon name="chat-bubble-left-ellipsis" class="w-5 h-5 text-white mt-0.5 shrink-0" />
                            <div>
                                <p class="text-xs text-[#aac7ff] mb-0.5">{{ __('site.contact.whatsapp') }}</p>
                                <a href="{{ $siteContent->whatsapp_url }}" target="_blank" rel="noopener noreferrer" class="text-sm font-semibold text-white hover:text-[#d7e3ff] transition">WhatsApp</a>
                            </div>
                        </li>
                        @endif

                        @if($siteContent->address)
                        <li class="flex items-start gap-4 p-4 rounded-lg bg-white/5 border border-white/10 hover:border-white/30 transition-colors">
                            <x-icon name="map-pin" class="w-5 h-5 text-white mt-0.5 shrink-0" />
                            <div>
                                <p class="text-xs text-[#aac7ff] mb-0.5">{{ __('site.contact.address') }}</p>
                                <p class="text-sm font-semibold text-white leading-snug">{{ $siteContent->address }}</p>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>

                @if($siteContent->whatsapp_url || $siteContent->linkedin_url || $siteContent->instagram_url)
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20">
                    <p class="text-xs font-bold uppercase tracking-widest text-[#aac7ff] mb-4">{{ __('site.contact.follow_us') }}</p>
                    <div class="flex gap-3">
                        @if($siteContent->whatsapp_url)
                            <a href="{{ $siteContent->whatsapp_url }}" target="_blank" rel="noopener noreferrer"
                               class="w-10 h-10 rounded-full bg-white/5 border border-white/10 hover:bg-[#25D366]/20 hover:border-[#25D366]/40 flex items-center justify-center transition-all">
                                <svg class="w-4 h-4 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            </a>
                        @endif
                        @if($siteContent->linkedin_url)
                            <a href="{{ $siteContent->linkedin_url }}" target="_blank" rel="noopener noreferrer"
                               class="w-10 h-10 rounded-full bg-white/5 border border-white/10 hover:bg-[#0A66C2]/20 hover:border-[#0A66C2]/40 flex items-center justify-center transition-all">
                                <svg class="w-4 h-4 text-[#0A66C2]" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            </a>
                        @endif
                        @if($siteContent->instagram_url)
                            <a href="{{ $siteContent->instagram_url }}" target="_blank" rel="noopener noreferrer"
                               class="w-10 h-10 rounded-full bg-white/5 border border-white/10 hover:bg-pink-500/20 hover:border-pink-500/40 flex items-center justify-center transition-all">
                                <svg class="w-4 h-4 text-pink-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            {{-- Formulário --}}
            <div class="lg:col-span-7 bg-white rounded-xl border border-[#e1e2eb] p-7 lg:p-10 shadow-2xl">
                <h2 class="text-lg font-bold text-[#191c22] mb-6 flex items-center gap-2">
                    <x-icon name="document-text" class="w-5 h-5 text-[#0066cc]" />
                    {{ __('site.contact.form_heading') }}
                </h2>
                <livewire:quote-form />
            </div>

        </div>
    </div>
</section>

@endsection
