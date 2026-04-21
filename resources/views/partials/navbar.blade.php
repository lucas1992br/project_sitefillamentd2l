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

        <a href="{{ route('home') }}" class="flex items-center gap-2.5">
            @php($logoUrl = \App\Models\SiteContent::instance()->getFirstMediaUrl('logo'))
            @if($logoUrl)
                <img src="{{ $logoUrl }}" alt="Logotipo" class="h-10 w-auto object-contain" />
            @else
                <div class="w-7 h-7 rounded bg-blue-500 flex items-center justify-center shrink-0">
                    <x-icon name="wrench-screwdriver" class="w-4 h-4 text-white" />
                </div>
            @endif
            <span class="text-white font-semibold text-sm tracking-tight leading-tight">
                D2L<br><span class="text-blue-400 font-light text-xs tracking-widest uppercase">Soluções Metálicas</span>
            </span>
        </a>

        <div class="hidden md:flex items-center gap-7">
            <a href="{{ route('home') }}#quem-somos"      class="text-xs font-medium text-blue-200/80 hover:text-white transition tracking-wide uppercase">Quem Somos</a>
            <a href="{{ route('home') }}#services"        class="text-xs font-medium text-blue-200/80 hover:text-white transition tracking-wide uppercase">Serviços</a>
            <a href="{{ route('home') }}#portfolio"       class="text-xs font-medium text-blue-200/80 hover:text-white transition tracking-wide uppercase">Portfólio</a>
            <a href="{{ route('home') }}#catalog"         class="text-xs font-medium text-blue-200/80 hover:text-white transition tracking-wide uppercase">Catálogo</a>
            <a href="{{ route('home') }}#certifications"  class="text-xs font-medium text-blue-200/80 hover:text-white transition tracking-wide uppercase">Certificações</a>
            <a href="{{ route('home') }}#contact"         class="text-xs font-medium text-blue-200/80 hover:text-white transition tracking-wide uppercase">Contato</a>
        </div>

        <a href="{{ request()->routeIs('home') ? '#contact' : route('contact') }}"
           class="hidden md:inline-flex items-center gap-2 px-5 py-2 rounded-full bg-blue-500 text-white text-xs font-semibold hover:bg-blue-400 transition shadow-lg shadow-blue-500/30">
            <x-icon name="document-text" class="w-3.5 h-3.5" />
            Solicite um Orçamento
        </a>

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
        <a href="{{ route('home') }}#quem-somos"      @click="mobileOpen=false" class="text-sm text-blue-200 hover:text-white transition">Quem Somos</a>
        <a href="{{ route('home') }}#services"        @click="mobileOpen=false" class="text-sm text-blue-200 hover:text-white transition">Serviços</a>
        <a href="{{ route('home') }}#portfolio"       @click="mobileOpen=false" class="text-sm text-blue-200 hover:text-white transition">Portfólio</a>
        <a href="{{ route('home') }}#catalog"         @click="mobileOpen=false" class="text-sm text-blue-200 hover:text-white transition">Catálogo</a>
        <a href="{{ route('home') }}#certifications"  @click="mobileOpen=false" class="text-sm text-blue-200 hover:text-white transition">Certificações</a>
        <a href="{{ route('home') }}#contact"         @click="mobileOpen=false" class="text-sm text-blue-200 hover:text-white transition">Contato</a>
        <a href="{{ request()->routeIs('home') ? '#contact' : route('contact') }}"
           @click="mobileOpen=false"
           class="mt-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full bg-blue-500 text-white text-sm font-semibold">
            Solicite um Orçamento
        </a>
    </div>
</nav>
