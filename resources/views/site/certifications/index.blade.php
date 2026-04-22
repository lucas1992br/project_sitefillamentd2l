@extends('layouts.site')

@section('title', 'Certificações — ' . config('app.name'))
@section('description', 'Nossas certificações de qualidade e acreditações, incluindo ISO 9001.')

@section('content')

    <section class="bg-blue-950 text-white py-16">
        <div class="max-w-7xl mx-auto px-6">
            </br>
            <p class="text-xs font-medium tracking-widest text-blue-300 uppercase mb-3">Qualidade</p>
            <h1 class="text-4xl font-bold mb-4">Certificações</h1>
            <p class="text-blue-200 max-w-xl leading-relaxed">
                Gestão de qualidade e conformidade verificadas independentemente.
            </p>
        </div>
    </section>

    <livewire:certs-section />

@endsection
