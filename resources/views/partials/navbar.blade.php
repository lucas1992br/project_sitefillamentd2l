<nav
    x-data="{
        scrolled: false,
        isHome: {{ request()->routeIs('home') ? 'true' : 'false' }},
        mobileOpen: false
    }"
    @scroll.window="scrolled = window.scrollY > 70"
    :class="(!isHome || scrolled)
        ? 'bg-slate-950/95 backdrop-blur-md shadow-lg shadow-black/30'
        : 'bg-transparent'"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-500"
>
    <div class="max-w-7xl mx-auto px-6 flex items-center justify-between h-16">

        @php($logoUrl = \App\Models\SiteContent::instance()->getFirstMediaUrl('logo'))
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 shrink-0">
            @if($logoUrl)
                <img src="{{ $logoUrl }}" alt="D2L Soluções Metálicas" class="h-10 sm:h-12 md:h-14 w-auto object-contain" />
            @else
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded bg-blue-500 flex items-center justify-center shrink-0">
                        <x-icon name="wrench-screwdriver" class="w-4 h-4 text-white" />
                    </div>
                    <span class="text-white font-semibold text-sm tracking-tight leading-tight">
                        D2L<br><span class="text-blue-400 font-light text-xs tracking-widest uppercase">Soluções Metálicas</span>
                    </span>
                </div>
            @endif
        </a>

        @php($hasNews = \App\Models\News::published()->exists())
        @php($hasCertifications = \App\Models\Certification::active()->exists())
        @php($hasCatalog = \App\Models\CatalogItem::active()->exists())
        <div class="hidden md:flex items-center gap-7">
            <a href="{{ route('home') }}"               class="text-sm font-semibold text-blue-200/80 hover:text-white transition tracking-wide uppercase">{{ __('site.nav.home') }}</a>
            <a href="{{ route('home') }}#services"      class="text-sm font-semibold text-blue-200/80 hover:text-white transition tracking-wide uppercase">{{ __('site.nav.services') }}</a>
            <a href="{{ route('home') }}#portfolio"     class="text-sm font-semibold text-blue-200/80 hover:text-white transition tracking-wide uppercase">{{ __('site.nav.portfolio') }}</a>
            @if($hasCatalog)
                <a href="{{ route('home') }}#catalog"   class="text-sm font-semibold text-blue-200/80 hover:text-white transition tracking-wide uppercase">{{ __('site.nav.catalog') }}</a>
            @endif
            @if($hasCertifications)
                <a href="{{ route('home') }}#certifications" class="text-sm font-semibold text-blue-200/80 hover:text-white transition tracking-wide uppercase">{{ __('site.nav.certifications') }}</a>
            @endif
            @if($hasNews)
                <a href="{{ route('news.index') }}"     class="text-sm font-semibold text-blue-200/80 hover:text-white transition tracking-wide uppercase">{{ __('site.nav.news') }}</a>
            @endif
            <a href="{{ route('home') }}#quem-somos"   class="text-sm font-semibold text-blue-200/80 hover:text-white transition tracking-wide uppercase">{{ __('site.nav.about') }}</a>
            <a href="{{ route('home') }}#contact"       class="text-sm font-semibold text-blue-200/80 hover:text-white transition tracking-wide uppercase">{{ __('site.nav.contact') }}</a>
        </div>

        <div class="hidden md:flex items-center gap-3">
            {{-- Language switcher --}}
            <div class="flex items-center gap-1 border border-white/10 rounded-full px-1.5 py-1">
                <a href="{{ route('locale.switch', 'pt') }}"
                   class="text-xs font-semibold px-2 py-0.5 rounded-full transition {{ app()->getLocale() === 'pt' ? 'bg-blue-500 text-white' : 'text-blue-300/70 hover:text-white' }}">
                    PT
                </a>
                <a href="{{ route('locale.switch', 'en') }}"
                   class="text-xs font-semibold px-2 py-0.5 rounded-full transition {{ app()->getLocale() === 'en' ? 'bg-blue-500 text-white' : 'text-blue-300/70 hover:text-white' }}">
                    EN
                </a>
            </div>

            <a href="{{ request()->routeIs('home') ? '#contact' : route('contact') }}"
               class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-blue-500 text-white text-xs font-semibold hover:bg-blue-400 transition shadow-lg shadow-blue-500/30">
                <x-icon name="document-text" class="w-3.5 h-3.5" />
                {{ __('site.nav.quote') }}
            </a>
        </div>

        <button @click="mobileOpen = !mobileOpen" class="md:hidden text-white p-1" aria-label="Menu">
            <x-icon x-show="!mobileOpen" name="bars-3"    class="w-6 h-6" />
            <x-icon x-show="mobileOpen"  name="x-mark"    class="w-6 h-6" />
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
        class="md:hidden bg-slate-950/98 backdrop-blur-md border-t border-white/5 px-6 py-5 flex flex-col gap-4"
    >
        <a href="{{ route('home') }}"               @click="mobileOpen=false" class="text-sm text-blue-200 hover:text-white transition">{{ __('site.nav.home') }}</a>
        <a href="{{ route('home') }}#services"      @click="mobileOpen=false" class="text-sm text-blue-200 hover:text-white transition">{{ __('site.nav.services') }}</a>
        <a href="{{ route('home') }}#portfolio"     @click="mobileOpen=false" class="text-sm text-blue-200 hover:text-white transition">{{ __('site.nav.portfolio') }}</a>
        @if($hasCatalog)
            <a href="{{ route('home') }}#catalog"   @click="mobileOpen=false" class="text-sm text-blue-200 hover:text-white transition">{{ __('site.nav.catalog') }}</a>
        @endif
        @if($hasCertifications)
            <a href="{{ route('home') }}#certifications" @click="mobileOpen=false" class="text-sm text-blue-200 hover:text-white transition">{{ __('site.nav.certifications') }}</a>
        @endif
        @if($hasNews)
            <a href="{{ route('news.index') }}"     @click="mobileOpen=false" class="text-sm text-blue-200 hover:text-white transition">{{ __('site.nav.news') }}</a>
        @endif
        <a href="{{ route('home') }}#quem-somos"   @click="mobileOpen=false" class="text-sm text-blue-200 hover:text-white transition">{{ __('site.nav.about') }}</a>
        <a href="{{ route('home') }}#contact"       @click="mobileOpen=false" class="text-sm text-blue-200 hover:text-white transition">{{ __('site.nav.contact') }}</a>

        {{-- Mobile language switcher --}}
        <div class="flex items-center gap-2 pt-1 border-t border-white/5">
            <span class="text-xs text-blue-400/60 uppercase tracking-widest">{{ app()->getLocale() === 'pt' ? 'Idioma' : 'Language' }}</span>
            <a href="{{ route('locale.switch', 'pt') }}"
               class="text-xs font-semibold px-2 py-0.5 rounded-full transition {{ app()->getLocale() === 'pt' ? 'bg-blue-500 text-white' : 'text-blue-300/70 hover:text-white' }}">
                PT
            </a>
            <a href="{{ route('locale.switch', 'en') }}"
               class="text-xs font-semibold px-2 py-0.5 rounded-full transition {{ app()->getLocale() === 'en' ? 'bg-blue-500 text-white' : 'text-blue-300/70 hover:text-white' }}">
                EN
            </a>
        </div>

        <a href="{{ request()->routeIs('home') ? '#contact' : route('contact') }}"
           @click="mobileOpen=false"
           class="mt-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full bg-blue-500 text-white text-sm font-semibold">
            {{ __('site.nav.quote') }}
        </a>
    </div>
</nav>
