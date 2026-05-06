@extends('layouts.site')

@section('title', __('site.news.title') . ' — ' . config('app.name'))
@section('description', __('site.news.description'))

@section('content')

    {{-- Page header --}}
    <section class="py-16 bg-[#f9f9ff] border-b border-[#e1e2eb]">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <p class="text-xs font-bold tracking-widest text-[#0066cc] uppercase mb-3">{{ __('site.news.tag') }}</p>
            <h1 class="text-4xl md:text-5xl font-bold text-[#191c22] tracking-tight mb-4">{{ __('site.news.title') }}</h1>
            <p class="text-[#414753] max-w-xl leading-relaxed text-lg">{{ __('site.news.description') }}</p>
        </div>
    </section>

    {{-- Listagem --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12">

            @if($news->isEmpty())
                <div class="text-center py-24">
                    <x-icon name="newspaper" class="w-12 h-12 text-[#c1c6d5] mx-auto mb-4" />
                    <p class="text-[#727784] text-sm">{{ __('site.news.empty') }}</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($news as $item)
                        <a href="{{ route('news.show', $item->slug) }}"
                           class="group bg-white rounded-xl border border-[#e1e2eb] overflow-hidden il-card-hover transition-all duration-300 hover:-translate-y-1 block">

                            @if($item->getFirstMedia('cover'))
                                <img
                                    src="{{ $item->getFirstMediaUrl('cover', 'thumb') ?: $item->getFirstMediaUrl('cover') }}"
                                    alt="{{ td($item->title) }}"
                                    class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500"
                                >
                            @else
                                <div class="w-full h-48 bg-[#ecedf6] flex items-center justify-center">
                                    <x-icon name="newspaper" class="w-10 h-10 text-[#c1c6d5]" />
                                </div>
                            @endif

                            <div class="p-6">
                                @if($item->published_at)
                                    <p class="text-xs text-[#0066cc] font-bold uppercase tracking-wider mb-2">
                                        {{ $item->published_at->format('d/m/Y') }}
                                    </p>
                                @endif

                                <h2 class="text-base font-bold text-[#191c22] mb-2 leading-snug group-hover:text-[#0066cc] transition-colors">
                                    {{ td($item->title) }}
                                </h2>

                                @if($item->excerpt)
                                    <p class="text-sm text-[#414753] leading-relaxed line-clamp-3">
                                        {{ td($item->excerpt) }}
                                    </p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $news->links() }}
                </div>
            @endif

        </div>
    </section>

@endsection
