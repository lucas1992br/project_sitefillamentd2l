@php($footerContent = \App\Models\SiteContent::instance())
@php($hasClients = \App\Models\Client::active()->exists())
<footer class="bg-[#191c22] text-[#9ca3af]">
    <div class="max-w-7xl mx-auto px-6 md:px-12 py-14">
        {{-- Navigation em linha --}}
        <div class="py-6 border-b border-white/10">
            <h3 class="text-white text-xs font-bold uppercase tracking-widest mb-4">{{ __('site.footer.navigation') }}</h3>
            <div class="flex flex-wrap gap-x-6 gap-y-2">
                <a href="{{ route('home') }}" class="text-sm hover:text-white transition-colors">{{ __('site.nav.home') }}</a>
                <a href="{{ route('home') }}#quem-somos" class="text-sm hover:text-white transition-colors">{{ __('site.nav.about') }}</a>
                <a href="{{ route('certifications.index') }}" class="text-sm hover:text-white transition-colors">{{ __('site.nav.certifications') }}</a>
                <a href="{{ route('services.index') }}" class="text-sm hover:text-white transition-colors">{{ __('site.nav.services') }}</a>
                <a href="{{ route('portfolio.index') }}" class="text-sm hover:text-white transition-colors">{{ __('site.nav.portfolio') }}</a>
                <a href="{{ route('catalog.index') }}" class="text-sm hover:text-white transition-colors">{{ __('site.nav.catalog') }}</a>
                @if($hasClients)
                    <a href="{{ route('home') }}#clientes" class="text-sm hover:text-white transition-colors">{{ __('site.nav.clients') }}</a>
                @endif
                @if(\App\Models\News::published()->exists())
                    <a href="{{ route('news.index') }}" class="text-sm hover:text-white transition-colors">{{ __('site.nav.news') }}</a>
                @endif
                <a href="{{ route('contact') }}" class="text-sm hover:text-white transition-colors">{{ __('site.nav.contact') }}</a>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 pb-10 border-b border-white/10 mt-10">

            {{-- Brand --}}
            <div>
                @php($footerLogoUrl = $footerContent->getFirstMediaUrl('logo_footer'))
                @php($footerLogoFallback = !$footerLogoUrl && ($footerLogoUrl = $footerContent->getFirstMediaUrl('logo')))
                @if($footerLogoUrl)
                    <a href="{{ route('home') }}" class="inline-block mb-4">
                        <img src="{{ $footerLogoUrl }}" alt="{{ config('app.name') }}"
                             class="h-20 w-auto object-contain {{ $footerLogoFallback ? 'brightness-0 invert' : '' }}" />
                    </a>
                @else
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 mb-4 w-fit">
                        <div class="w-8 h-8 rounded-lg bg-[#0066cc] flex items-center justify-center shrink-0">
                            <x-icon name="wrench-screwdriver" class="w-4 h-4 text-white" />
                        </div>
                        <span class="text-white font-bold text-lg tracking-tight">{{ config('app.name') }}</span>
                    </a>
                @endif

                @if($footerContent->about_description)
                    <p class="text-sm leading-relaxed text-[#9ca3af] max-w-xs line-clamp-3">
                        {{ Str::limit(strip_tags($footerContent->about_description), 160) }}
                    </p>
                @endif

                @if($footerContent->whatsapp_url || $footerContent->linkedin_url || $footerContent->instagram_url)
                    <div class="flex items-center gap-2 mt-6">
                        @if($footerContent->whatsapp_url)
                            <a href="{{ $footerContent->whatsapp_url }}" target="_blank" rel="noopener noreferrer"
                               class="w-9 h-9 rounded-full bg-white/5 border border-white/10 hover:bg-[#25D366]/20 hover:border-[#25D366]/40 flex items-center justify-center transition-all">
                                <svg class="w-4 h-4 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            </a>
                        @endif
                        @if($footerContent->linkedin_url)
                            <a href="{{ $footerContent->linkedin_url }}" target="_blank" rel="noopener noreferrer"
                               class="w-9 h-9 rounded-full bg-white/5 border border-white/10 hover:bg-[#0A66C2]/20 hover:border-[#0A66C2]/40 flex items-center justify-center transition-all">
                                <svg class="w-4 h-4 text-[#0A66C2]" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            </a>
                        @endif
                        @if($footerContent->instagram_url)
                            <a href="{{ $footerContent->instagram_url }}" target="_blank" rel="noopener noreferrer"
                               class="w-9 h-9 rounded-full bg-white/5 border border-white/10 hover:bg-pink-500/20 hover:border-pink-500/40 flex items-center justify-center transition-all">
                                <svg class="w-4 h-4 text-pink-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Contact --}}
            <div>
                <h3 class="text-white text-xs font-bold uppercase tracking-widest mb-4">{{ __('site.footer.contact') }}</h3>
                <ul class="space-y-3">
                    @if($footerContent->contact_email)
                        <li class="flex items-start gap-2.5">
                            <x-icon name="envelope" class="w-4 h-4 text-[#0066cc] mt-0.5 shrink-0" />
                            <a href="mailto:{{ $footerContent->contact_email }}" class="text-sm hover:text-white transition-colors break-all">{{ $footerContent->contact_email }}</a>
                        </li>
                    @endif
                    @if($footerContent->phone)
                        <li class="flex items-start gap-2.5">
                            <x-icon name="phone" class="w-4 h-4 text-[#0066cc] mt-0.5 shrink-0" />
                            <a href="tel:{{ $footerContent->phone }}" class="text-sm hover:text-white transition-colors">{{ $footerContent->phone }}</a>
                        </li>
                    @endif
                    @if($footerContent->address)
                        <li class="flex items-start gap-2.5">
                            <x-icon name="map-pin" class="w-4 h-4 text-[#0066cc] mt-0.5 shrink-0" />
                            <span class="text-sm leading-relaxed">{{ $footerContent->address }}</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        

        <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-xs text-[#6b7280]">
                &copy; {{ date('Y') }} <span class="text-white font-semibold">{{ config('app.name') }}</span>. {{ __('site.footer.rights') }}
            </p>
            <div class="flex items-center gap-4">
                <a href="{{ route('locale.switch', 'pt') }}"
                   class="text-xs font-semibold px-2.5 py-1 rounded-full transition {{ app()->getLocale() === 'pt' ? 'bg-[#0066cc] text-white' : 'text-[#9ca3af] hover:text-white' }}">PT</a>
                <a href="{{ route('locale.switch', 'en') }}"
                   class="text-xs font-semibold px-2.5 py-1 rounded-full transition {{ app()->getLocale() === 'en' ? 'bg-[#0066cc] text-white' : 'text-[#9ca3af] hover:text-white' }}">EN</a>
            </div>
        </div>
    </div>
</footer>
