@extends('layouts.site')

@section('title', 'Contato & Orçamento — ' . config('app.name'))
@section('description', 'Entre em contato para solicitar um orçamento ou tirar dúvidas sobre nossos serviços de usinagem CNC.')

@section('content')

    {{-- Hero --}}
    <section class="bg-slate-950 text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-tech-grid opacity-40 pointer-events-none"></div>
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-blue-500/40 to-transparent"></div>
        <div class="relative max-w-7xl mx-auto px-6">
            <p class="text-xs font-semibold tracking-widest text-blue-400 uppercase mb-3">Fale Conosco</p>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Entre em Contato</h1>
            <p class="text-blue-200/70 max-w-xl leading-relaxed">
                Preencha o formulário e nossa equipe retornará em breve com uma proposta.
            </p>
        </div>
    </section>

    {{-- Conteúdo --}}
    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-12">

                {{-- Informações de contato --}}
                <div class="lg:col-span-2 space-y-8">

                    <div>
                        <h2 class="text-xs font-semibold uppercase tracking-widest text-blue-600 mb-5">Informações de Contato</h2>
                        <ul class="space-y-5">
                            <li class="flex items-start gap-3">
                                <div class="w-9 h-9 rounded-lg bg-blue-500/10 border border-blue-500/20 flex items-center justify-center shrink-0 mt-0.5">
                                    <x-icon name="envelope" class="w-4 h-4 text-blue-600" />
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 mb-0.5">E-mail</p>
                                    <a href="mailto:contato@d2l.ind.br" class="text-sm text-slate-700 hover:text-blue-600 transition font-medium">
                                        contato@d2l.ind.br
                                    </a>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-9 h-9 rounded-lg bg-blue-500/10 border border-blue-500/20 flex items-center justify-center shrink-0 mt-0.5">
                                    <x-icon name="phone" class="w-4 h-4 text-blue-600" />
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 mb-0.5">Telefone</p>
                                    <a href="tel:+5512997517673" class="text-sm text-slate-700 hover:text-blue-600 transition font-medium">
                                        +55 (12) 99751-7673
                                    </a>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-9 h-9 rounded-lg bg-green-500/10 border border-green-500/20 flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 mb-0.5">WhatsApp</p>
                                    <a href="https://wa.me/5512997517673" target="_blank" rel="noopener noreferrer"
                                       class="text-sm text-slate-700 hover:text-green-600 transition font-medium">
                                        +55 (12) 99751-7673
                                    </a>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-9 h-9 rounded-lg bg-blue-500/10 border border-blue-500/20 flex items-center justify-center shrink-0 mt-0.5">
                                    <x-icon name="map-pin" class="w-4 h-4 text-blue-600" />
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 mb-0.5">Endereço</p>
                                    <p class="text-sm text-slate-700 font-medium leading-relaxed">
                                        Rodovia João Amaral Gurgel, N4800<br>Bairro Piedade, Caçapava/SP</p>
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Formulário --}}
                <div class="lg:col-span-3 bg-slate-900 rounded-2xl border border-white/5 p-8">
                    <h2 class="text-sm font-semibold text-white mb-6">Solicite um Orçamento</h2>
                    <livewire:quote-form />
                </div>

            </div>
        </div>
    </section>

@endsection
