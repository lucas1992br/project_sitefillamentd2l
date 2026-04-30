<?php

namespace App\Filament\Pages;

use App\Models\SiteContent;
use Exception;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ManageSiteContent extends Page
{
    protected string $view = 'filament.pages.manage-site-content';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-film';

    protected static ?string $navigationLabel = 'Conteúdo do Site';

    protected static string|\UnitEnum|null $navigationGroup = 'Website Content';

    protected static ?int $navigationSort = 2;

    public ?array $data = [];

    public SiteContent $record;

    public function mount(): void
    {
        $this->record = SiteContent::instance();

        $this->form->fill([
            'showcase_video_active'      => $this->record->showcase_video_active,
            'hero_poster_active'         => $this->record->hero_poster_active,
            'about_active'               => $this->record->about_active,
            'about_title'                => $this->record->about_title,
            'about_description'          => $this->record->about_description,
            'about_founded_year'         => $this->record->about_founded_year,
            'whatsapp_url'               => $this->record->whatsapp_url,
            'facebook_url'               => $this->record->facebook_url,
            'instagram_url'              => $this->record->instagram_url,
            'seo_title'                  => $this->record->seo_title,
            'seo_description'            => $this->record->seo_description,
            'seo_keywords'               => $this->record->seo_keywords,
            'google_analytics_id'        => $this->record->google_analytics_id,
            'google_tag_manager_id'      => $this->record->google_tag_manager_id,
            'google_search_console_meta' => $this->record->google_search_console_meta,
            'robots_index'               => $this->record->robots_index,
            'contact_email'              => $this->record->contact_email,
            'smtp_host'                  => $this->record->smtp_host,
            'smtp_port'                  => $this->record->smtp_port,
            'smtp_encryption'            => $this->record->smtp_encryption,
            'smtp_username'              => $this->record->smtp_username,
            'smtp_password'              => $this->record->smtp_password,
            'mail_from_address'          => $this->record->mail_from_address,
            'mail_from_name'             => $this->record->mail_from_name,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->model($this->record)
            ->statePath('data')
            ->components([
                Section::make('Logotipo')
                    ->description('Logotipo da empresa exibido no cabeçalho e rodapé do site.')
                    ->afterHeader([
                        \Filament\Actions\Action::make('delete_logo')
                            ->label('Excluir Logotipo')
                            ->color('danger')
                            ->icon('heroicon-o-trash')
                            ->requiresConfirmation()
                            ->modalHeading('Excluir logotipo?')
                            ->modalDescription('Esta ação não pode ser desfeita.')
                            ->visible(fn () => $this->record->hasMedia('logo'))
                            ->action(fn () => $this->deleteMedia('logo')),
                    ])
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('logo')
                            ->label('Arquivo do Logotipo')
                            ->helperText('Formatos aceitos: PNG, SVG, WebP · Recomendado: fundo transparente (PNG ou SVG)')
                            ->collection('logo')
                            ->image()
                            ->imageEditor()
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/avif', 'image/svg+xml'])
                            ->model($this->record),
                    ]),

                Section::make('Quem Somos')
                    ->description('Seção de apresentação da empresa exibida na página inicial.')
                    ->afterHeader([
                        \Filament\Actions\Action::make('delete_about_image')
                            ->label('Excluir Foto')
                            ->color('danger')
                            ->icon('heroicon-o-trash')
                            ->requiresConfirmation()
                            ->modalHeading('Excluir foto da empresa?')
                            ->modalDescription('Esta ação não pode ser desfeita.')
                            ->visible(fn () => $this->record->hasMedia('about_image'))
                            ->action(fn () => $this->deleteMedia('about_image')),
                    ])
                    ->schema([
                        Toggle::make('about_active')
                            ->label('Seção ativa')
                            ->helperText('Quando desativado, a seção "Quem Somos" não aparece no site.')
                            ->onColor('success')
                            ->offColor('danger')
                            ->live(),

                        TextInput::make('about_title')
                            ->label('Título da Seção')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Sobre a D2L'),

                        Textarea::make('about_description')
                            ->label('Descrição / História da Empresa')
                            ->rows(6)
                            ->maxLength(2000)
                            ->placeholder('Conte a história da empresa, seus valores, missão e diferenciais...'),

                        TextInput::make('about_founded_year')
                            ->label('Ano de Fundação')
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue((int) date('Y'))
                            ->placeholder('Ex: 2005'),

                        SpatieMediaLibraryFileUpload::make('about_image')
                            ->label('Foto da Empresa')
                            ->helperText('Imagem exibida ao lado do texto · Recomendado: 800×600 px')
                            ->collection('about_image')
                            ->image()
                            ->imageEditor()
                            ->maxSize(5120)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/avif'])
                            ->model($this->record),
                    ]),

                Section::make('Vídeo de Apresentação')
                    ->description('Vídeo exibido na seção "Veja em Ação" da página inicial.')
                    ->afterHeader([
                        \Filament\Actions\Action::make('delete_showcase_video')
                            ->label('Excluir Vídeo')
                            ->color('danger')
                            ->icon('heroicon-o-trash')
                            ->requiresConfirmation()
                            ->modalHeading('Excluir vídeo de apresentação?')
                            ->modalDescription('Esta ação não pode ser desfeita.')
                            ->visible(fn () => $this->record->hasMedia('showcase_video'))
                            ->action(fn () => $this->deleteMedia('showcase_video')),
                    ])
                    ->schema([
                        Toggle::make('showcase_video_active')
                            ->label('Seção ativa')
                            ->helperText('Quando desativado, a seção "Veja em Ação" não aparece no site.')
                            ->onColor('success')
                            ->offColor('danger')
                            ->live(),

                        SpatieMediaLibraryFileUpload::make('showcase_video')
                            ->label('Arquivo de Vídeo (Equipamentos em Operação)')
                            ->helperText('Formatos aceitos: MP4, WebM · Tamanho máximo: 100 MB')
                            ->collection('showcase_video')
                            ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/ogg'])
                            ->maxSize(100 * 1024)
                            ->model($this->record),
                    ]),

                Section::make('Redes Sociais')
                    ->description('Links das redes sociais exibidos no botão flutuante do site.')
                    ->schema([
                        TextInput::make('whatsapp_url')
                            ->label('WhatsApp')
                            ->placeholder('https://wa.me/5511999999999')
                            ->helperText('Use o formato: https://wa.me/55DDD999999999')
                            ->url()
                            ->maxLength(255),

                        TextInput::make('facebook_url')
                            ->label('Facebook')
                            ->placeholder('https://facebook.com/sua-pagina')
                            ->url()
                            ->maxLength(255),

                        TextInput::make('instagram_url')
                            ->label('Instagram')
                            ->placeholder('https://instagram.com/seu-perfil')
                            ->url()
                            ->maxLength(255),
                    ])
                    ->columns(3),

                Section::make('E-mail de Contato')
                    ->description('Configurações para receber as mensagens do formulário de orçamento do site.')
                    ->icon('heroicon-o-envelope')
                    ->afterHeader([
                        \Filament\Actions\Action::make('test_mail')
                            ->label('Testar Conexão')
                            ->icon('heroicon-o-paper-airplane')
                            ->color('info')
                            ->requiresConfirmation()
                            ->modalHeading('Enviar e-mail de teste?')
                            ->modalDescription('Um e-mail de teste será enviado para o endereço configurado em "E-mail de Destino" usando as credenciais SMTP salvas.')
                            ->modalSubmitActionLabel('Enviar Agora')
                            ->action(fn () => $this->testMailConnection()),
                    ])
                    ->schema([
                        TextInput::make('contact_email')
                            ->label('E-mail de Destino')
                            ->helperText('Para este endereço serão enviadas as solicitações de orçamento recebidas pelo site.')
                            ->email()
                            ->required()
                            ->maxLength(150)
                            ->placeholder('contato@d2l.ind.br'),

                        TextInput::make('smtp_host')
                            ->label('Servidor SMTP (Host)')
                            ->helperText('Ex: smtp.gmail.com · smtp.hostinger.com · smtp.office365.com')
                            ->maxLength(255)
                            ->placeholder('smtp.gmail.com'),

                        TextInput::make('smtp_port')
                            ->label('Porta SMTP')
                            ->helperText('Gmail/TLS: 587 · SSL: 465')
                            ->numeric()
                            ->placeholder('587'),

                        Select::make('smtp_encryption')
                            ->label('Criptografia')
                            ->options([
                                'tls'  => 'TLS (recomendado)',
                                'ssl'  => 'SSL',
                                ''     => 'Nenhuma',
                            ])
                            ->default('tls'),

                        TextInput::make('smtp_username')
                            ->label('Usuário SMTP')
                            ->helperText('Geralmente o próprio endereço de e-mail.')
                            ->maxLength(150)
                            ->placeholder('contato@d2l.ind.br'),

                        TextInput::make('smtp_password')
                            ->label('Senha SMTP / Senha de App')
                            ->helperText('No Gmail, use uma "Senha de app" gerada em Segurança da conta Google.')
                            ->password()
                            ->revealable()
                            ->maxLength(255),

                        TextInput::make('mail_from_address')
                            ->label('E-mail Remetente (From)')
                            ->helperText('Endereço que aparece como remetente nos e-mails enviados. Deve ser o mesmo do usuário SMTP.')
                            ->email()
                            ->maxLength(150)
                            ->placeholder('contato@d2l.ind.br'),

                        TextInput::make('mail_from_name')
                            ->label('Nome Remetente')
                            ->helperText('Nome que aparece como remetente. Ex: D2L Soluções Metálicas')
                            ->maxLength(100)
                            ->placeholder('D2L Soluções Metálicas'),
                    ])
                    ->columns(2),

                Section::make('SEO & Rastreamento')
                    ->description('Configurações de indexação, metadados e códigos de rastreamento do Google.')
                    ->icon('heroicon-o-magnifying-glass')
                    ->schema([
                        TextInput::make('seo_title')
                            ->label('Título SEO')
                            ->helperText('Sobrescreve o título padrão nas abas e resultados do Google. Ideal: 50–60 caracteres.')
                            ->maxLength(70)
                            ->placeholder('D2L — Usinagem CNC e Soluções Metálicas em Caçapava'),

                        Textarea::make('seo_description')
                            ->label('Meta Description')
                            ->helperText('Descrição exibida nos resultados do Google. Ideal: 120–160 caracteres.')
                            ->rows(3)
                            ->maxLength(320)
                            ->placeholder('Usinagem CNC, soldagem e acabamento com tolerâncias de ±0.003 mm. ISO 9001. Desde 2005.'),

                        TextInput::make('seo_keywords')
                            ->label('Palavras-chave (Keywords)')
                            ->helperText('Separadas por vírgula. Influência limitada no Google, mas útil para outros motores.')
                            ->maxLength(500)
                            ->placeholder('usinagem cnc, torneamento, soldagem, caçapava, são paulo'),

                        Toggle::make('robots_index')
                            ->label('Permitir indexação pelo Google')
                            ->helperText('Quando desativado, adiciona "noindex, nofollow" — útil durante desenvolvimento.')
                            ->onColor('success')
                            ->offColor('danger'),

                        TextInput::make('google_analytics_id')
                            ->label('Google Analytics 4 — Measurement ID')
                            ->helperText('Formato: G-XXXXXXXXXX · Encontre em: GA4 → Admin → Fluxos de dados')
                            ->maxLength(50)
                            ->placeholder('G-XXXXXXXXXX'),

                        TextInput::make('google_tag_manager_id')
                            ->label('Google Tag Manager — Container ID')
                            ->helperText('Formato: GTM-XXXXXXX · Encontre em: GTM → Admin → Container')
                            ->maxLength(50)
                            ->placeholder('GTM-XXXXXXX'),

                        TextInput::make('google_search_console_meta')
                            ->label('Google Search Console — Meta Tag de Verificação')
                            ->helperText('Cole apenas o valor do atributo "content" da meta tag fornecida pelo Search Console.')
                            ->maxLength(100)
                            ->placeholder('abc123xyz_verificação'),
                    ])
                    ->columns(2),

                Section::make('Imagem de Fundo do Hero (Poster)')
                    ->description('Imagem exibida enquanto o vídeo carrega.')
                    ->afterHeader([
                        \Filament\Actions\Action::make('delete_hero_poster')
                            ->label('Excluir Imagem')
                            ->color('danger')
                            ->icon('heroicon-o-trash')
                            ->requiresConfirmation()
                            ->modalHeading('Excluir imagem de fundo do hero?')
                            ->modalDescription('Esta ação não pode ser desfeita.')
                            ->visible(fn () => $this->record->hasMedia('hero_poster'))
                            ->action(fn () => $this->deleteMedia('hero_poster')),
                    ])
                    ->schema([
                        Toggle::make('hero_poster_active')
                            ->label('Conteúdo ativo')
                            ->helperText('Quando desativado, o poster não será exibido no site.')
                            ->onColor('success')
                            ->offColor('danger')
                            ->live(),

                        SpatieMediaLibraryFileUpload::make('hero_poster')
                            ->label('Arquivo de Imagem')
                            ->helperText('Recomendado: 1920×1080 px')
                            ->collection('hero_poster')
                            ->image()
                            ->imageEditor()
                            ->maxSize(5120)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/avif'])
                            ->model($this->record),
                    ]),
            ]);
    }

    public function testMailConnection(): void
    {
        // Always read fresh from DB to avoid Livewire serialization losing field values
        $site = SiteContent::query()->find(1);

        if (! $site?->contact_email) {
            Notification::make()->warning()->title('E-mail de destino não configurado.')->send();

            return;
        }

        if (! $site->smtp_host) {
            Notification::make()->warning()->title('Servidor SMTP não configurado.')->send();

            return;
        }

        if (! $site->smtp_password) {
            Notification::make()
                ->warning()
                ->title('Senha SMTP não encontrada no banco.')
                ->body('Salve o formulário com a senha preenchida e tente novamente.')
                ->persistent()
                ->send();

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

        try {
            \Illuminate\Support\Facades\Mail::raw(
                "Este é um e-mail de teste enviado pelo painel administrativo da D2L.\n\nSe você recebeu esta mensagem, a configuração SMTP está funcionando corretamente.",
                fn ($m) => $m->to($site->contact_email)->subject('Teste de Conexão — D2L Painel Admin'),
            );

            Notification::make()
                ->success()
                ->title('E-mail enviado com sucesso!')
                ->body("Verifique a caixa de entrada de {$site->contact_email}.")
                ->send();
        } catch (Exception $e) {
            Notification::make()
                ->danger()
                ->title('Falha no envio')
                ->body($e->getMessage())
                ->persistent()
                ->send();
        }
    }

    public function deleteMedia(string $collection): void
    {
        $this->record->clearMediaCollection($collection);
        $this->record->refresh();

        $this->form->fill([
            'showcase_video_active'      => $this->record->showcase_video_active,
            'hero_poster_active'         => $this->record->hero_poster_active,
            'about_active'               => $this->record->about_active,
            'about_title'                => $this->record->about_title,
            'about_description'          => $this->record->about_description,
            'about_founded_year'         => $this->record->about_founded_year,
            'whatsapp_url'               => $this->record->whatsapp_url,
            'facebook_url'               => $this->record->facebook_url,
            'instagram_url'              => $this->record->instagram_url,
            'seo_title'                  => $this->record->seo_title,
            'seo_description'            => $this->record->seo_description,
            'seo_keywords'               => $this->record->seo_keywords,
            'google_analytics_id'        => $this->record->google_analytics_id,
            'google_tag_manager_id'      => $this->record->google_tag_manager_id,
            'google_search_console_meta' => $this->record->google_search_console_meta,
            'robots_index'               => $this->record->robots_index,
            'contact_email'              => $this->record->contact_email,
            'smtp_host'                  => $this->record->smtp_host,
            'smtp_port'                  => $this->record->smtp_port,
            'smtp_encryption'            => $this->record->smtp_encryption,
            'smtp_username'              => $this->record->smtp_username,
            'smtp_password'              => $this->record->smtp_password,
            'mail_from_address'          => $this->record->mail_from_address,
            'mail_from_name'             => $this->record->mail_from_name,
        ]);

        Notification::make()
            ->success()
            ->title('Arquivo excluído com sucesso!')
            ->send();
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $this->record->update([
            'showcase_video_active'      => $data['showcase_video_active'] ?? true,
            'hero_poster_active'         => $data['hero_poster_active'] ?? true,
            'about_active'               => $data['about_active'] ?? true,
            'about_title'                => $data['about_title'] ?? 'Sobre a D2L',
            'about_description'          => $data['about_description'] ?? null,
            'about_founded_year'         => $data['about_founded_year'] ?? null,
            'whatsapp_url'               => $data['whatsapp_url'] ?? null,
            'facebook_url'               => $data['facebook_url'] ?? null,
            'instagram_url'              => $data['instagram_url'] ?? null,
            'seo_title'                  => $data['seo_title'] ?? null,
            'seo_description'            => $data['seo_description'] ?? null,
            'seo_keywords'               => $data['seo_keywords'] ?? null,
            'google_analytics_id'        => $data['google_analytics_id'] ?? null,
            'google_tag_manager_id'      => $data['google_tag_manager_id'] ?? null,
            'google_search_console_meta' => $data['google_search_console_meta'] ?? null,
            'robots_index'               => $data['robots_index'] ?? true,
            'contact_email'              => $data['contact_email'] ?? null,
            'smtp_host'                  => $data['smtp_host'] ?? null,
            'smtp_port'                  => $data['smtp_port'] ?? null,
            'smtp_encryption'            => $data['smtp_encryption'] ?? 'tls',
            'smtp_username'              => $data['smtp_username'] ?? null,
            'smtp_password'              => $data['smtp_password'] ?: $this->record->smtp_password,
            'mail_from_address'          => $data['mail_from_address'] ?? null,
            'mail_from_name'             => $data['mail_from_name'] ?? null,
        ]);

        $this->form->saveRelationships();

        Notification::make()
            ->success()
            ->title('Conteúdo salvo com sucesso!')
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            \Filament\Actions\Action::make('save')
                ->label('Salvar')
                ->submit('save'),
        ];
    }
}
