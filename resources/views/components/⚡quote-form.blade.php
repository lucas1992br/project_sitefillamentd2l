<?php

use App\Mail\QuoteRequestMail;
use App\Models\SiteContent;
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

    #[Validate('required|string|max:2000')]
    public string $message = '';

    public bool $submitted = false;

    public function submit(): void
    {
        $this->validate();

        $site = SiteContent::instance();

        if (! $site->contact_email) {
            $this->toast()->error('Configuração pendente', 'O e-mail de destino ainda não foi configurado pelo administrador.')->send();
            return;
        }

        $this->applySmtpSettings($site);

        \Illuminate\Support\Facades\Mail::to($site->contact_email)
            ->send(new QuoteRequestMail(
                senderName:  $this->name,
                senderEmail: $this->email,
                phone:       $this->phone,
                company:     $this->company,
                service:     '',
                messageBody: $this->message,
            ));

        $this->submitted = true;

        $this->toast()->success('Recebemos Sua Solicitação', 'Entraremos em contato em breve.')->send();

        $this->reset(['name', 'email', 'phone', 'company', 'message']);
    }

    private function applySmtpSettings(SiteContent $site): void
    {
        if (! $site->smtp_host) {
            return;
        }

        $encryption = $site->smtp_encryption ?: 'tls';
        $port = $site->smtp_port ?? 587;

        config([
            'mail.mailers.smtp.host'       => $site->smtp_host,
            'mail.mailers.smtp.port'       => $port,
            'mail.mailers.smtp.encryption' => $encryption,
            'mail.mailers.smtp.scheme'     => ($encryption === 'ssl' || $port == 465) ? 'smtps' : null,
            'mail.mailers.smtp.username'   => $site->smtp_username,
            'mail.mailers.smtp.password'   => $site->smtp_password,
            'mail.from.address'            => $site->mail_from_address ?: $site->smtp_username,
            'mail.from.name'               => $site->mail_from_name ?: config('app.name'),
            'mail.default'                 => 'smtp',
        ]);
    }
};
?>

<div>
    @if ($submitted)
        <div class="text-center py-12">
            <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
                <x-icon name="check-circle" class="w-8 h-8 text-green-600" />
            </div>
            <h3 class="text-lg font-semibold text-white mb-2">{{ __('site.form.success_title') }}</h3>
            <p class="text-sm text-slate-400">{{ __('site.form.success_message') }}</p>
            <button wire:click="$set('submitted', false)" class="mt-6 text-sm text-blue-400 hover:underline">
                {{ __('site.form.send_another') }}
            </button>
        </div>
    @else
        <form wire:submit="submit" class="grid grid-cols-1 sm:grid-cols-2 gap-5">

            {{-- Nome --}}
            <div>
                <label class="block text-xs font-medium text-slate-300 mb-1.5">
                    {{ __('site.form.full_name') }} <span class="text-blue-400">*</span>
                </label>
                <input
                    wire:model="name"
                    type="text"
                    placeholder="{{ __('site.form.placeholder_name') }}"
                    class="w-full rounded-lg border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                >
                @error('name') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- E-mail --}}
            <div>
                <label class="block text-xs font-medium text-slate-300 mb-1.5">
                    {{ __('site.form.email') }} <span class="text-blue-400">*</span>
                </label>
                <input
                    wire:model="email"
                    type="email"
                    placeholder="{{ __('site.form.placeholder_email') }}"
                    class="w-full rounded-lg border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                >
                @error('email') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Telefone --}}
            <div>
                <label class="block text-xs font-medium text-slate-300 mb-1.5">
                    {{ __('site.form.phone') }}
                </label>
                <input
                    wire:model="phone"
                    type="tel"
                    placeholder="{{ __('site.form.placeholder_phone') }}"
                    class="w-full rounded-lg border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                >
                @error('phone') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Empresa --}}
            <div>
                <label class="block text-xs font-medium text-slate-300 mb-1.5">
                    {{ __('site.form.company') }} <span class="text-blue-400">*</span>
                </label>
                <input
                    wire:model="company"
                    type="text"
                    placeholder="{{ __('site.form.placeholder_company') }}"
                    class="w-full rounded-lg border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                >
                @error('company') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Mensagem — ocupa as 2 colunas --}}
            <div class="sm:col-span-2">
                <label class="block text-xs font-medium text-slate-300 mb-1.5">
                    {{ __('site.form.project_details') }} <span class="text-blue-400">*</span>
                </label>
                <textarea
                    wire:model="message"
                    rows="5"
                    placeholder="{{ __('site.form.placeholder_message') }}"
                    class="w-full rounded-lg border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                ></textarea>
                @error('message') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Botão — ocupa as 2 colunas --}}
            <div class="sm:col-span-2">
                <x-button
                    type="submit"
                    color="primary"
                    :text="__('site.form.submit')"
                    class="w-full justify-center rounded-lg"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading wire:target="submit" class="mr-2">
                        <x-icon name="arrow-path" class="w-4 h-4 animate-spin inline" />
                    </span>
                </x-button>
            </div>

        </form>
    @endif
</div>
