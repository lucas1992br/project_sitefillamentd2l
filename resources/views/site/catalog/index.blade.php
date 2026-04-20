@extends('layouts.site')

@section('title', 'Catálogo — ' . config('app.name'))
@section('description', 'Explore nosso catálogo de produtos e soluções metálicas.')

@section('content')

    <section class="bg-blue-950 text-white py-16">
        <div class="max-w-7xl mx-auto px-6">
            <p class="text-xs font-medium tracking-widest text-blue-300 uppercase mb-3">Produtos</p>
            <h1 class="text-4xl font-bold mb-4">Catálogo</h1>
            <p class="text-blue-200 max-w-xl leading-relaxed">
                Conheça nossos produtos e soluções disponíveis, organizados por categoria.
            </p>
        </div>
    </section>

    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <livewire:catalog-grid />
        </div>
    </section>

@endsection
