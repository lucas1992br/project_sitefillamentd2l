@extends('layouts.site')

@section('title', 'Certifications — ' . config('app.name'))
@section('description', 'Our quality certifications and accreditations including ISO 9001.')

@section('content')

    <section class="bg-blue-950 text-white py-16">
        <div class="max-w-7xl mx-auto px-6">
            <p class="text-xs font-medium tracking-widest text-blue-300 uppercase mb-3">Quality</p>
            <h1 class="text-4xl font-bold mb-4">Certifications</h1>
            <p class="text-blue-200 max-w-xl leading-relaxed">
                Independently verified quality management and compliance.
            </p>
        </div>
    </section>

    <livewire:certs-section />

@endsection
