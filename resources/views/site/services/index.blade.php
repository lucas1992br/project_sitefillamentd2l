@extends('layouts.site')

@section('title', 'Serviços — ' . config('app.name'))
@section('description', 'Serviços completos de usinagem industrial CNC: torneamento, fresamento, soldagem e acabamento de superfície.')

@section('content')

    <section class="bg-blue-950 text-white py-16">
        <div class="max-w-7xl mx-auto px-6">
            </br>
            <h1 class="text-4xl font-bold mb-4">Serviços</h1>
            <p class="text-blue-200 max-w-xl leading-relaxed">
                Serviços completos de usinagem industrial CNC: torneamento, fresamento, soldagem e acabamento de superfície.
            </p>
        </div>
    </section>

    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($services as $service)
                    <x-card class="border border-blue-100 border-t-4 border-t-blue-500 hover:shadow-md transition">
                        @php
                            $images = collect();
                            $cover = $service->getFirstMedia('cover');
                            if ($cover) {
                                $images->push([
                                    'thumb' => $cover->hasGeneratedConversion('card') ? $cover->getUrl('card') : $cover->getUrl(),
                                    'full'  => $cover->getUrl(),
                                    'alt'   => $service->title,
                                ]);
                            }
                            foreach ($service->getMedia('gallery') as $media) {
                                $images->push([
                                    'thumb' => $media->hasGeneratedConversion('card') ? $media->getUrl('card') : $media->getUrl(),
                                    'full'  => $media->getUrl(),
                                    'alt'   => $service->title,
                                ]);
                            }
                        @endphp
                        @if ($images->isNotEmpty())
                            <x-image-slider :images="$images" height="h-44" class="mb-4" />
                        @endif

                        <h2 class="text-base font-semibold text-blue-900 mb-1">{{ $service->title }}</h2>

                        @if ($service->subtitle)
                            <x-badge color="primary" :text="$service->subtitle" class="mb-3" />
                        @endif

                        <div class="text-sm text-gray-500 leading-relaxed prose prose-sm max-w-none">
                            {!! $service->description !!}
                        </div>
                    </x-card>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-16 bg-blue-900 text-white text-center">
        <div class="max-w-2xl mx-auto px-6">
            <h2 class="text-2xl font-bold mb-3">Precisa de uma peça personalizada?</h2>
            <p class="text-blue-200 mb-8">Fale sobre seu projeto e retornaremos com um orçamento.</p>
            <x-button
                href="{{ route('contact') }}"
                color="white"
                text="Solicitar Orçamento"
                class="rounded-full px-10"
            />
        </div>
    </section>

@endsection
