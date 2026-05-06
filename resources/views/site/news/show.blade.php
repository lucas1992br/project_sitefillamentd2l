@extends('layouts.site')

@section('title', td($item->title) . ' — ' . config('app.name'))
@section('description', td($item->excerpt ?? ''))

@section('content')

{{-- Hero da notícia --}}
<section class="bg-[#f9f9ff] border-b border-[#e1e2eb]">
    <div class="max-w-4xl mx-auto px-6 md:px-12 py-10">
        <a href="{{ route('news.index') }}"
           class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#0066cc] hover:text-[#004e9f] transition mb-6">
            <x-icon name="arrow-left" class="w-4 h-4" />
            {{ __('site.news.title') }}
        </a>

        @if($item->published_at)
            <p class="text-xs font-bold text-[#0066cc] uppercase tracking-widest mb-3">
                {{ $item->published_at->format('d/m/Y') }}
            </p>
        @endif

        <h1 class="text-3xl md:text-4xl font-bold text-[#191c22] leading-tight tracking-tight mb-4">
            {{ td($item->title) }}
        </h1>

        @if($item->excerpt)
            <p class="text-lg text-[#414753] leading-relaxed mb-8">{{ td($item->excerpt) }}</p>
        @endif

        @if($item->getFirstMedia('cover'))
            <div class="w-64 h-64 rounded-xl overflow-hidden border border-[#e1e2eb] shadow-sm">
                <img src="{{ $item->getFirstMediaUrl('cover', 'thumb') ?: $item->getFirstMediaUrl('cover') }}"
                     alt="{{ td($item->title) }}"
                     class="w-full h-full object-cover">
            </div>
        @endif
    </div>
</section>

{{-- Corpo --}}
<section class="py-14 bg-white">
    <div class="max-w-4xl mx-auto px-6 md:px-12">

        @if($item->body)
            <div class="prose prose-lg max-w-none text-[#414753]
                        prose-headings:text-[#191c22] prose-headings:font-bold
                        prose-a:text-[#0066cc] prose-a:no-underline hover:prose-a:underline
                        prose-img:rounded-xl prose-img:border prose-img:border-[#e1e2eb]
                        prose-blockquote:border-l-[#0066cc] prose-blockquote:text-[#414753]">
                {!! td($item->body) !!}
            </div>
        @endif

    </div>
</section>

{{-- Outras notícias --}}
@if($related->isNotEmpty())
<section class="py-16 bg-[#f9f9ff] border-t border-[#e1e2eb]">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <h2 class="text-xl font-bold text-[#191c22] mb-8">{{ __('site.news.related') }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($related as $news)
                <a href="{{ route('news.show', $news->slug) }}"
                   class="group bg-white rounded-xl border border-[#e1e2eb] overflow-hidden il-card-hover transition-all duration-300 hover:-translate-y-1 block">

                    @if($news->getFirstMedia('cover'))
                        <img src="{{ $news->getFirstMediaUrl('cover', 'thumb') ?: $news->getFirstMediaUrl('cover') }}"
                             alt="{{ td($news->title) }}"
                             class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-44 bg-[#ecedf6] flex items-center justify-center">
                            <x-icon name="newspaper" class="w-10 h-10 text-[#c1c6d5]" />
                        </div>
                    @endif

                    <div class="p-5">
                        @if($news->published_at)
                            <p class="text-xs text-[#0066cc] font-bold uppercase tracking-wider mb-2">
                                {{ $news->published_at->format('d/m/Y') }}
                            </p>
                        @endif
                        <h3 class="text-sm font-bold text-[#191c22] leading-snug group-hover:text-[#0066cc] transition-colors">
                            {{ td($news->title) }}
                        </h3>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
