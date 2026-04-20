<?php

use Livewire\Attributes\Validate;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

new class extends Component
{
    use Interactions;

    #[Validate('required|string|max:100')]
    public string $name = '';

    #[Validate('required|email|max:150')]
    public string $email = '';

    #[Validate('nullable|string|max:30')]
    public string $phone = '';

    #[Validate('required|string|max:100')]
    public string $company = '';

    #[Validate('required|string|in:cnc-turning,cnc-milling,welding,finishing,other')]
    public string $service = '';

    #[Validate('required|string|max:2000')]
    public string $message = '';

    public bool $submitted = false;

    public function submit(): void
    {
        $this->validate();

        // TODO: queue a mail job
        \Illuminate\Support\Facades\Mail::raw(
            "Solicitação de orçamento de {$this->name} ({$this->email})\n\n" .
            "Empresa: {$this->company}\nTelefone: {$this->phone}\nServiço: {$this->service}\n\n{$this->message}",
            fn ($m) => $m->to(config('mail.from.address'))->subject('Nova Solicitação de Orçamento')
        );

        $this->submitted = true;

        $this->toast()->success('Solicitação enviada!', 'Retornaremos em até 24 horas úteis.')->send();

        $this->reset(['name', 'email', 'phone', 'company', 'service', 'message']);
    }
};
?>

<div>
    @if ($submitted)
        <div class="text-center py-12">
            <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
                <x-icon name="check-circle" class="w-8 h-8 text-green-600" />
            </div>
            <h3 class="text-lg font-semibold text-blue-900 mb-2">Obrigado!</h3>
            <p class="text-sm text-gray-500">Sua solicitação foi recebida. Entraremos em contato em breve.</p>
            <button wire:click="$set('submitted', false)" class="mt-6 text-sm text-blue-600 hover:underline">
                Enviar outra solicitação
            </button>
        </div>
    @else
        <form wire:submit="submit" class="space-y-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-medium text-white mb-1">Nome Completo *</label>
                    <input
                        wire:model="name"
                        type="text"
                        placeholder="João Silva"
                        class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                    @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-white mb-1">E-mail *</label>
                    <input
                        wire:model="email"
                        type="email"
                        placeholder="joao@empresa.com.br"
                        class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                    @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-white mb-1">Telefone</label>
                    <input
                        wire:model="phone"
                        type="tel"
                        placeholder="+55 (11) 00000-0000"
                        class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                    @error('phone') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-white mb-1">Empresa *</label>
                    <input
                        wire:model="company"
                        type="text"
                        placeholder="Empresa Ltda"
                        class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                    @error('company') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-medium text-white mb-1">Serviço Necessário *</label>
                <select
                    wire:model="service"
                    class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value="">Selecione um serviço…</option>
                    <option value="cnc-turning">Torneamento CNC</option>
                    <option value="cnc-milling">Fresamento CNC</option>
                    <option value="welding">Soldagem</option>
                    <option value="finishing">Acabamento Superficial</option>
                    <option value="other">Outro</option>
                </select>
                @error('service') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-medium text-white mb-1">Detalhes do Projeto *</label>
                <textarea
                    wire:model="message"
                    rows="5"
                    placeholder="Descreva sua peça, material, tolerâncias, quantidade e prazo…"
                    class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                ></textarea>
                @error('message') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <x-button
                type="submit"
                color="primary"
                text="Enviar Solicitação de Orçamento"
                class="w-full justify-center rounded-lg"
                wire:loading.attr="disabled"
            >
                <span wire:loading wire:target="submit" class="mr-2">
                    <x-icon name="arrow-path" class="w-4 h-4 animate-spin inline" />
                </span>
            </x-button>
        </form>
    @endif
</div>
