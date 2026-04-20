@extends('layouts.site')

@section('title', 'Contact & Quote — ' . config('app.name'))
@section('description', 'Get in touch to request a quote or ask about our CNC machining services.')

@section('content')

    <section class="bg-blue-950 text-white py-16">
        <div class="max-w-7xl mx-auto px-6">
            <p class="text-xs font-medium tracking-widest text-blue-300 uppercase mb-3">Get in Touch</p>
            <h1 class="text-4xl font-bold mb-4">Contact Us</h1>
            <p class="text-blue-200 max-w-xl leading-relaxed">
                Fill in the form and we'll respond within one business day.
            </p>
        </div>
    </section>

    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

                {{-- Contact info --}}
                <div class="space-y-8">
                    <div>
                        <h2 class="text-sm font-semibold text-blue-900 mb-4">Contact Information</h2>
                        <ul class="space-y-3 text-sm text-gray-600">
                            <li class="flex items-start gap-3">
                                <x-icon name="envelope" class="w-5 h-5 text-blue-500 mt-0.5 shrink-0" />
                                <a href="mailto:contact@precisionmachining.com" class="hover:text-blue-600 transition">
                                    contact@precisionmachining.com
                                </a>
                            </li>
                            <li class="flex items-start gap-3">
                                <x-icon name="phone" class="w-5 h-5 text-blue-500 mt-0.5 shrink-0" />
                                <a href="tel:+5511999999999" class="hover:text-blue-600 transition">
                                    +55 11 99999-9999
                                </a>
                            </li>
                            <li class="flex items-start gap-3">
                                <x-icon name="map-pin" class="w-5 h-5 text-blue-500 mt-0.5 shrink-0" />
                                <span>Rua das Máquinas, 100<br>São Paulo — SP, Brazil</span>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h2 class="text-sm font-semibold text-blue-900 mb-3">Business Hours</h2>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>Mon – Fri: 08:00 – 18:00</li>
                            <li>Saturday: 08:00 – 12:00</li>
                            <li class="text-gray-400">Sunday: Closed</li>
                        </ul>
                    </div>
                </div>

                {{-- Quote form --}}
                <div class="lg:col-span-2">
                    <x-card class="border border-blue-100">
                        <h2 class="text-sm font-semibold text-blue-900 mb-6">Request a Quote</h2>
                        <livewire:quote-form />
                    </x-card>
                </div>

            </div>
        </div>
    </section>

@endsection
