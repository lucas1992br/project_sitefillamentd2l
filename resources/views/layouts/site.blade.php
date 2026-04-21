@php($siteContent = \App\Models\SiteContent::instance())
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $siteContent->seo_title ?? config('app.name'))</title>
    <meta name="description" content="@yield('description', $siteContent->seo_description ?? 'Usinagem CNC, soldagem e acabamento certificados ISO 9001.')">
    @if($siteContent->seo_keywords)
        <meta name="keywords" content="{{ $siteContent->seo_keywords }}">
    @endif
    <meta name="robots" content="{{ $siteContent->robots_index ? 'index, follow' : 'noindex, nofollow' }}">
    @if($siteContent->google_search_console_meta)
        <meta name="google-site-verification" content="{{ $siteContent->google_search_console_meta }}">
    @endif

    {{-- Google Tag Manager --}}
    @if($siteContent->google_tag_manager_id)
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','{{ $siteContent->google_tag_manager_id }}');</script>
    @endif

    {{-- Google Analytics 4 (standalone, sem GTM) --}}
    @if($siteContent->google_analytics_id && !$siteContent->google_tag_manager_id)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $siteContent->google_analytics_id }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $siteContent->google_analytics_id }}');
        </script>
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&family=Roboto:wght@300;400&display=swap" rel="stylesheet">

    <tallstackui:script />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-white text-gray-900 antialiased">
    {{-- Google Tag Manager (noscript) --}}
    @if($siteContent->google_tag_manager_id)
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $siteContent->google_tag_manager_id }}"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif

    <x-toast />
    <x-dialog />

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    @include('partials.social-float')

    @livewireScripts
    @stack('scripts')
</body>
</html>
