<footer class="bg-blue-950 text-blue-300 py-12">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">

            <div>
                @php($footerLogoUrl = \App\Models\SiteContent::instance()->getFirstMediaUrl('logo'))
                @if($footerLogoUrl)
                    <a href="{{ route('home') }}">
                        <img src="{{ $footerLogoUrl }}" alt="D2L Soluções Metálicas" class="h-10 sm:h-12 md:h-14 w-auto object-contain mb-3" />
                    </a>
                @else
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-7 h-7 rounded bg-blue-500 flex items-center justify-center shrink-0">
                            <x-icon name="wrench-screwdriver" class="w-4 h-4 text-white" />
                        </div>
                        <span class="text-white font-semibold text-sm tracking-tight leading-tight">
                            D2L<br><span class="text-blue-400 font-light text-xs tracking-widest uppercase">Soluções Metálicas</span>
                        </span>
                    </div>
                @endif
            </div>

            <div>
                <h3 class="text-white font-semibold text-sm mb-3">{{ __('site.footer.navigation') }}</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-xs hover:text-white transition">{{ __('site.nav.home') }}</a></li>
                    <li><a href="{{ route('home') }}#quem-somos" class="text-xs hover:text-white transition">{{ __('site.nav.about') }}</a></li>
                    <li><a href="{{ route('certifications.index') }}" class="text-xs hover:text-white transition">{{ __('site.nav.certifications') }}</a></li>
                    <li><a href="{{ route('services.index') }}" class="text-xs hover:text-white transition">{{ __('site.nav.services') }}</a></li>
                </ul>
            </div>

            <div>
                <ul class="space-y-2 mt-6">
                    <li><a href="{{ route('portfolio.index') }}" class="text-xs hover:text-white transition">{{ __('site.nav.portfolio') }}</a></li>
                    <li><a href="{{ route('catalog.index') }}" class="text-xs hover:text-white transition">{{ __('site.nav.catalog') }}</a></li>
                    @if(\App\Models\News::published()->exists())
                        <li><a href="{{ route('news.index') }}" class="text-xs hover:text-white transition">{{ __('site.nav.news') }}</a></li>
                    @endif
                    <li><a href="{{ route('contact') }}" class="text-xs hover:text-white transition">{{ __('site.nav.contact') }}</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-white font-semibold text-sm mb-3">{{ __('site.footer.contact') }}</h3>
                <p class="text-xs leading-relaxed">
                    Email: <a href="mailto:contato@d2l.ind.br" class="hover:text-white transition">contato@d2l.ind.br</a>
                </p>
                <p class="text-xs mt-1">
                    {{ __('site.footer.phone') }}: <a href="tel:+5512997517673" class="hover:text-white transition">+55 12 99751-7673</a>
                </p>
            </div>

        </div>

        @php($social = \App\Models\SiteContent::instance())
        @if($social->whatsapp_url || $social->facebook_url || $social->instagram_url)
            <div class="border-t border-blue-900 pt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-blue-500">
                    &copy; {{ date('Y') }} <b>D2L Soluções Metálicas</b>. {{ __('site.footer.rights') }}
                </p>
                <div class="flex items-center gap-3">
                    @if($social->whatsapp_url)
                        <a href="{{ $social->whatsapp_url }}" target="_blank" rel="noopener noreferrer"
                           class="w-8 h-8 rounded-full bg-white/5 border border-white/10 hover:bg-[#25D366]/20 hover:border-[#25D366]/40 flex items-center justify-center transition-all"
                           title="WhatsApp">
                            <svg class="w-3.5 h-3.5 text-blue-400 hover:text-[#25D366] transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </a>
                    @endif
                    @if($social->facebook_url)
                        <a href="{{ $social->facebook_url }}" target="_blank" rel="noopener noreferrer"
                           class="w-8 h-8 rounded-full bg-white/5 border border-white/10 hover:bg-[#1877F2]/20 hover:border-[#1877F2]/40 flex items-center justify-center transition-all"
                           title="Facebook">
                            <svg class="w-3.5 h-3.5 text-blue-400 hover:text-[#1877F2] transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                    @endif
                    @if($social->instagram_url)
                        <a href="{{ $social->instagram_url }}" target="_blank" rel="noopener noreferrer"
                           class="w-8 h-8 rounded-full bg-white/5 border border-white/10 hover:bg-pink-500/20 hover:border-pink-500/40 flex items-center justify-center transition-all"
                           title="Instagram">
                            <svg class="w-3.5 h-3.5 text-blue-400 hover:text-pink-400 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        @else
            <div class="border-t border-blue-900 pt-6 text-center">
                <p class="text-xs text-blue-500">
                    &copy; {{ date('Y') }} <b>D2L Soluções Metálicas</b>. {{ __('site.footer.rights') }}
                </p>
            </div>
        @endif
    </div>
</footer>
