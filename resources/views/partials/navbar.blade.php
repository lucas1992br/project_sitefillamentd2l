<nav
    x-data="{ mobileOpen: false, scrolled: false }"
    @scroll.window="scrolled = window.scrollY > 10"
    :class="scrolled ? 'shadow-sm shadow-black/5' : ''"
    class="sticky top-0 z-50 w-full bg-white/95 backdrop-blur-md border-b border-[#c1c6d5] transition-shadow duration-300"
>
    <div class="max-w-7xl mx-auto px-4 md:px-12 flex items-center justify-between h-20">

        @php($logoUrl = \App\Models\SiteContent::instance()->getFirstMediaUrl('logo'))
        <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0">
            @if($logoUrl)
                <img src="{{ $logoUrl }}" alt="{{ config('app.name') }}" class="h-20 sm:h-24 w-auto object-contain" />
            @else
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-[#0066cc] flex items-center justify-center shrink-0">
                        <x-icon name="wrench-screwdriver" class="w-4 h-4 text-white" />
                    </div>
                    <span class="text-[#191c22] font-bold text-lg tracking-tight leading-tight">
                        {{ config('app.name') }}
                    </span>
                </div>
            @endif
        </a>

        @php($hasNews = \App\Models\News::published()->exists())
        @php($hasCertifications = \App\Models\Certification::active()->exists())
        @php($hasCatalog = \App\Models\CatalogItem::active()->exists())
        @php($hasClients = \App\Models\Client::active()->exists())

        <div class="hidden md:flex items-center gap-8">
            <a href="{{ route('home') }}" class="text-sm font-semibold text-[#414753] hover:text-[#0066cc] transition-colors uppercase tracking-wider">{{ __('site.nav.home') }}</a>
            <a href="{{ route('home') }}#quem-somos" class="text-sm font-semibold text-[#414753] hover:text-[#0066cc] transition-colors uppercase tracking-wider">{{ __('site.nav.about') }}</a>
            @if($hasCertifications)
                <a href="{{ route('home') }}#certifications" class="text-sm font-semibold text-[#414753] hover:text-[#0066cc] transition-colors uppercase tracking-wider">{{ __('site.nav.certifications') }}</a>
            @endif
            <a href="{{ route('home') }}#services" class="text-sm font-semibold text-[#414753] hover:text-[#0066cc] transition-colors uppercase tracking-wider">{{ __('site.nav.services') }}</a>
            <a href="{{ route('home') }}#portfolio" class="text-sm font-semibold text-[#414753] hover:text-[#0066cc] transition-colors uppercase tracking-wider">{{ __('site.nav.portfolio') }}</a>
            @if($hasCatalog)
                <a href="{{ route('home') }}#catalog" class="text-sm font-semibold text-[#414753] hover:text-[#0066cc] transition-colors uppercase tracking-wider">{{ __('site.nav.catalog') }}</a>
            @endif
            @if($hasClients)
                <a href="{{ route('home') }}#clientes" class="text-sm font-semibold text-[#414753] hover:text-[#0066cc] transition-colors uppercase tracking-wider">{{ __('site.nav.clients') }}</a>
            @endif
            @if($hasNews)
                <a href="{{ route('news.index') }}" class="text-sm font-semibold text-[#414753] hover:text-[#0066cc] transition-colors uppercase tracking-wider">{{ __('site.nav.news') }}</a>
            @endif
            <a href="{{ route('contact') }}" class="text-sm font-semibold text-[#414753] hover:text-[#0066cc] transition-colors uppercase tracking-wider">{{ __('site.nav.contact') }}</a>
        </div>

        {{-- Language switcher com bandeiras --}}
        <div class="hidden md:flex items-center gap-2">
            <a href="{{ route('locale.switch', 'pt') }}" title="Português"
               class="rounded overflow-hidden transition-all {{ app()->getLocale() === 'pt' ? 'ring-2 ring-[#0066cc] ring-offset-1 shadow-sm' : 'opacity-50 hover:opacity-100' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 14" class="w-8 h-6">
                    <rect width="20" height="14" fill="#009C3B"/>
                    <polygon points="10,1.5 18.5,7 10,12.5 1.5,7" fill="#FFDF00"/>
                    <circle cx="10" cy="7" r="3.2" fill="#002776"/>
                    <path d="M7.1,8.2 Q10,6.2 12.9,8.2" stroke="white" stroke-width="0.7" fill="none" stroke-linecap="round"/>
                </svg>
            </a>
            <a href="{{ route('locale.switch', 'en') }}" title="English"
               class="rounded overflow-hidden transition-all {{ app()->getLocale() === 'en' ? 'ring-2 ring-[#0066cc] ring-offset-1 shadow-sm' : 'opacity-50 hover:opacity-100' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 14" class="w-8 h-6">
                    <rect width="20" height="14" fill="white"/>
                    <rect y="0"    width="20" height="1.08" fill="#B22234"/>
                    <rect y="2.15" width="20" height="1.08" fill="#B22234"/>
                    <rect y="4.31" width="20" height="1.08" fill="#B22234"/>
                    <rect y="6.46" width="20" height="1.08" fill="#B22234"/>
                    <rect y="8.62" width="20" height="1.08" fill="#B22234"/>
                    <rect y="10.77" width="20" height="1.08" fill="#B22234"/>
                    <rect y="12.92" width="20" height="1.08" fill="#B22234"/>
                    <rect width="8" height="7.7" fill="#3C3B6E"/>
                </svg>
            </a>
        </div>

        <button @click="mobileOpen = !mobileOpen" class="md:hidden text-[#414753] p-1" aria-label="Menu">
            <x-icon x-show="!mobileOpen" name="bars-3" class="w-6 h-6" />
            <x-icon x-show="mobileOpen" name="x-mark" class="w-6 h-6" />
        </button>
    </div>

    {{-- Mobile menu --}}
    <div
        x-show="mobileOpen"
        x-transition:enter="transition duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition duration-150"
        x-transition:leave-end="opacity-0"
        class="md:hidden bg-white border-t border-[#e1e2eb] px-6 py-5 flex flex-col gap-4"
    >
        <a href="{{ route('home') }}" @click="mobileOpen=false" class="text-sm font-semibold text-[#414753] hover:text-[#0066cc] transition-colors">{{ __('site.nav.home') }}</a>
        <a href="{{ route('home') }}#quem-somos" @click="mobileOpen=false" class="text-sm font-semibold text-[#414753] hover:text-[#0066cc] transition-colors">{{ __('site.nav.about') }}</a>
        @if($hasCertifications)
            <a href="{{ route('home') }}#certifications" @click="mobileOpen=false" class="text-sm font-semibold text-[#414753] hover:text-[#0066cc] transition-colors">{{ __('site.nav.certifications') }}</a>
        @endif
        <a href="{{ route('home') }}#services" @click="mobileOpen=false" class="text-sm font-semibold text-[#414753] hover:text-[#0066cc] transition-colors">{{ __('site.nav.services') }}</a>
        <a href="{{ route('home') }}#portfolio" @click="mobileOpen=false" class="text-sm font-semibold text-[#414753] hover:text-[#0066cc] transition-colors">{{ __('site.nav.portfolio') }}</a>
        @if($hasCatalog)
            <a href="{{ route('home') }}#catalog" @click="mobileOpen=false" class="text-sm font-semibold text-[#414753] hover:text-[#0066cc] transition-colors">{{ __('site.nav.catalog') }}</a>
        @endif
        @if($hasClients)
            <a href="{{ route('home') }}#clientes" @click="mobileOpen=false" class="text-sm font-semibold text-[#414753] hover:text-[#0066cc] transition-colors">{{ __('site.nav.clients') }}</a>
        @endif
        @if($hasNews)
            <a href="{{ route('news.index') }}" @click="mobileOpen=false" class="text-sm font-semibold text-[#414753] hover:text-[#0066cc] transition-colors">{{ __('site.nav.news') }}</a>
        @endif
        <a href="{{ route('contact') }}" @click="mobileOpen=false" class="text-sm font-semibold text-[#414753] hover:text-[#0066cc] transition-colors">{{ __('site.nav.contact') }}</a>

        {{-- Mobile language switcher --}}
        <div class="flex items-center gap-3 pt-2 border-t border-[#e1e2eb]">
            <a href="{{ route('locale.switch', 'pt') }}" title="Português"
               class="rounded overflow-hidden transition-all {{ app()->getLocale() === 'pt' ? 'ring-2 ring-[#0066cc] ring-offset-1' : 'opacity-50 hover:opacity-100' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 14" class="w-8 h-6">
                    <rect width="20" height="14" fill="#009C3B"/>
                    <polygon points="10,1.5 18.5,7 10,12.5 1.5,7" fill="#FFDF00"/>
                    <circle cx="10" cy="7" r="3.2" fill="#002776"/>
                    <path d="M7.1,8.2 Q10,6.2 12.9,8.2" stroke="white" stroke-width="0.7" fill="none" stroke-linecap="round"/>
                </svg>
            </a>
            <a href="{{ route('locale.switch', 'en') }}" title="English"
               class="rounded overflow-hidden transition-all {{ app()->getLocale() === 'en' ? 'ring-2 ring-[#0066cc] ring-offset-1' : 'opacity-50 hover:opacity-100' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 14" class="w-8 h-6">
                    <rect width="20" height="14" fill="white"/>
                    <rect y="0"    width="20" height="1.08" fill="#B22234"/>
                    <rect y="2.15" width="20" height="1.08" fill="#B22234"/>
                    <rect y="4.31" width="20" height="1.08" fill="#B22234"/>
                    <rect y="6.46" width="20" height="1.08" fill="#B22234"/>
                    <rect y="8.62" width="20" height="1.08" fill="#B22234"/>
                    <rect y="10.77" width="20" height="1.08" fill="#B22234"/>
                    <rect y="12.92" width="20" height="1.08" fill="#B22234"/>
                    <rect width="8" height="7.7" fill="#3C3B6E"/>
                </svg>
            </a>
        </div>
    </div>
</nav>
