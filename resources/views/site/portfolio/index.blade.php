@extends('layouts.site')

@section('title', 'Portifólio — ' . config('app.name'))
@section('description', 'Browse our portfolio of precision CNC machined parts and industrial projects.')

@section('content')

    <section class="bg-blue-950 text-white py-16">
        <div class="max-w-7xl mx-auto px-6">
</br>
            <h1 class="text-4xl font-bold mb-4">Portifólio</h1>
            <p class="text-blue-200 max-w-xl leading-relaxed">
                Uma seleção de projetos concluídos em diversas indústrias e materiais.
            </p>
        </div>
    </section>

    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <livewire:portfolio-grid />
        </div>
    </section>

@endsection
