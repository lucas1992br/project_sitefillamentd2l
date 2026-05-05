@extends('layouts.site')

@section('title', __('site.news.title') . ' — ' . config('app.name'))
@section('description', __('site.news.description'))

@section('content')

    {{-- Hero --}}
    <section class="bg-slate-950 text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-tech-grid opacity-40 pointer-events-none"></div>
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-blue-500/40 to-transparent"></div>
        <div class="relative max-w-7xl mx-auto px-6">
            <p class="text-xs font-semibold tracking-widest text-blue-400 uppercase mb-3">{{ __('site.news.tag') }}</p>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ __('site.news.title') }}</h1>
            <p class="text-blue-200/70 max-w-xl leading-relaxed">
                {{ __('site.news.description') }}
            </p>
        </div>
    </section>

    {{-- Listagem --}}
    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6">

            @if($news->isEmpty())
                <div class="text-center py-24">
                    <x-icon name="newspaper" class="w-12 h-12 text-slate-300 mx-auto mb-4" />
                    <p class="text-slate-400 text-sm">{{ __('site.news.empty') }}</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($news as $item)
                        <article class="bg-white rounded-2xl border border-slate-100 overflow-hidden card-glow transition-all duration-300 hover:-translate-y-1 hover:border-blue-200">

                            @if($item->getFirstMedia('cover'))
                                <img
                                    src="{{ $item->getFirstMediaUrl('cover', 'thumb') ?: $item->getFirstMediaUrl('cover') }}"
                                    alt="{{ $item->title }}"
                                    class="w-full h-48 object-cover"
                                >
                            @else
                                <div class="w-full h-48 bg-slate-100 flex items-center justify-center">
                                    <x-icon name="newspaper" class="w-10 h-10 text-slate-300" />
                                </div>
                            @endif

                            <div class="p-6">
                                @if($item->published_at)
                                    <p class="text-xs text-blue-500 font-semibold uppercase tracking-wider mb-2">
                                        {{ $item->published_at->format('d/m/Y') }}
                                    </p>
                                @endif

                                <h2 class="text-base font-bold text-slate-900 mb-2 leading-snug">
                                    {{ $item->title }}
                                </h2>

                                @if($item->excerpt)
                                    <p class="text-sm text-slate-500 leading-relaxed line-clamp-3">
                                        {{ $item->excerpt }}
                                    </p>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $news->links() }}
                </div>
            @endif

        </div>
    </section>

@endsection
