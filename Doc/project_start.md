# Precision Machining Website — Laravel 12 + Filament v5 + TallStackUI v3

> Full-stack Laravel 12 website for an industrial CNC machining company.
> Frontend powered by **TallStackUI v3** (Livewire v4 + TailwindCSS v4).
> Admin panel powered by **Filament v5** (Livewire v4).

---

## Table of Contents

1. [Project Overview](#1-project-overview)
2. [Requirements](#2-requirements)
3. [Installation](#3-installation)
4. [Database Structure](#4-database-structure)
5. [Migrations](#5-migrations)
6. [Eloquent Models](#6-eloquent-models)
7. [Filament v5 Admin Panel Setup](#7-filament-v5-admin-panel-setup)
8. [Filament Resources](#8-filament-resources)
9. [TallStackUI v3 Frontend Setup](#9-tallstackui-v3-frontend-setup)
10. [Livewire Components (Frontend)](#10-livewire-components-frontend)
11. [Frontend Routes & Controllers](#11-frontend-routes--controllers)
12. [Blade Views with TallStackUI](#12-blade-views-with-tallstackui)
13. [Seeders](#13-seeders)
14. [Final Checklist](#14-final-checklist)

---

## 1. Project Overview

### Architecture

```
Laravel 12
├── Filament v5              → Admin panel (CRUD for all dynamic content)
│   └── Livewire v4          → Required by Filament v5
├── TallStackUI v3           → Frontend Blade component kit (Livewire v4 + Alpine.js)
│   └── TailwindCSS v4       → Utility-first CSS (required by TallStackUI v3)
├── Spatie Media Library v11 → Image management (services, portfolio, certifications, clients)
├── PostgreSQL               → Primary database
└── Laravel Sail             → Local development (Docker)
```

> **Key point:** Both Filament v5 and TallStackUI v3 share **Livewire v4**. No version conflicts.
> TallStackUI v3 targets TailwindCSS v4 — Filament v5 is fully compatible with TailwindCSS v4.

### Dynamic Sections Managed via Filament v5

| Section        | Filament Resource        | TallStackUI Livewire Component  |
|----------------|--------------------------|---------------------------------|
| Services       | `ServiceResource`        | `<livewire:services-section>`   |
| Portfolio      | `PortfolioResource`      | `<livewire:portfolio-grid>`     |
| Certifications | `CertificationResource`  | `<livewire:certs-section>`      |
| Clients        | `ClientResource`         | `<livewire:clients-section>`    |

---

## 2. Requirements

| Dependency           | Version     |
|----------------------|-------------|
| PHP                  | >= 8.2      |
| Laravel              | 12.x        |
| Filament             | ^5.3        |
| Livewire             | ^4.0        |
| TallStackUI          | ^3.0        |
| TailwindCSS          | ^4.0        |
| Spatie Media Library | ^11.0       |
| PostgreSQL           | >= 15       |
| Node.js              | >= 20       |
| Laravel Sail         | latest      |

---

## 3. Installation

### 3.1 Create Laravel Project

```bash
composer create-project laravel/laravel precision-machining
cd precision-machining
```

### 3.2 Install Laravel Sail (Docker)

```bash
composer require laravel/sail --dev
php artisan sail:install
# Select: pgsql, redis
./vendor/bin/sail up -d
```

### 3.3 Install Livewire v4

Filament v5 pulls Livewire v4 automatically. If installing standalone first:

```bash
./vendor/bin/sail composer require livewire/livewire:"^4.0"
```

### 3.4 Install Filament v5

```bash
./vendor/bin/sail composer require filament/filament:"^5.3"
./vendor/bin/sail php artisan filament:install --panels
```

When prompted:
- Panel ID: `admin`
- Accept publishing assets: `yes`

### 3.5 Install Spatie Media Library

```bash
./vendor/bin/sail composer require spatie/laravel-medialibrary:"^11.0"
./vendor/bin/sail php artisan vendor:publish \
    --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" \
    --tag="medialibrary-migrations"
```

### 3.6 Install Filament Spatie Media Library Plugin

```bash
./vendor/bin/sail composer require filament/spatie-laravel-media-library-plugin:"^5.3"
```

### 3.7 Install TallStackUI v3

```bash
./vendor/bin/sail composer require tallstackui/tallstackui:"^3.0"
./vendor/bin/sail php artisan tallstackui:install
```

### 3.8 Install Node Dependencies & TailwindCSS v4

```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm install tailwindcss @tailwindcss/vite --save-dev
```

### 3.9 Configure `vite.config.js`

```js
// vite.config.js
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
})
```

### 3.10 Configure `resources/css/app.css`

```css
/* resources/css/app.css */
@import "tailwindcss";

/* TallStackUI source — required for component styles to be scanned by Tailwind v4 */
@source "../../vendor/tallstackui/tallstackui/src";

/* Custom brand color tokens */
@theme {
    --color-primary-50:  #E6F1FB;
    --color-primary-100: #B5D4F4;
    --color-primary-200: #85B7EB;
    --color-primary-400: #378ADD;
    --color-primary-600: #185FA5;
    --color-primary-800: #0C447C;
    --color-primary-900: #042C53;
}
```

### 3.11 Configure `.env`

```dotenv
APP_NAME="Precision Machining"
APP_URL=http://localhost

DB_CONNECTION=pgsql
DB_HOST=pgsql
DB_PORT=5432
DB_DATABASE=precision_machining
DB_USERNAME=sail
DB_PASSWORD=password

FILESYSTEM_DISK=public
QUEUE_CONNECTION=database
```

### 3.12 Create Storage Symlink

```bash
./vendor/bin/sail php artisan storage:link
```

### 3.13 Publish and Configure TallStackUI

```bash
./vendor/bin/sail php artisan vendor:publish --tag=tallstackui-config
```

```php
<?php
// config/tallstackui.php

return [
    'prefix' => '',          // Use <x-button> not <x-ts-button>

    'theme' => [
        'mode'  => 'light',  // 'light' | 'dark' | 'system'
        'color' => 'primary',
    ],

    'avatar' => [
        'default' => 'https://ui-avatars.com/api/',
    ],
];
```

---

## 4. Database Structure

### Entity Relationship Overview

```
services
├── id, title, subtitle, description, icon, slug, sort_order, is_active
└── media → collections: cover, gallery

portfolio_items
├── id, title, subtitle, description, category, material, tolerance,
│   client_name, sort_order, is_featured, is_active
└── media → collections: cover, gallery

certifications
├── id, name, issuer, certificate_number, issued_at, expires_at,
│   description, sort_order, is_active
└── media → collections: certificate, logo

clients
├── id, name, industry, website, testimonial, contact_name,
│   contact_role, is_featured, sort_order, is_active
└── media → collection: logo

site_settings
└── id, key (unique), value, group
```

---

## 5. Migrations

### 5.1 Services Table

```bash
./vendor/bin/sail php artisan make:migration create_services_table
```

```php
<?php
// database/migrations/xxxx_create_services_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description');
            $table->string('icon')->nullable();      // heroicon name or svg class
            $table->string('slug')->unique();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
```

### 5.2 Portfolio Items Table

```bash
./vendor/bin/sail php artisan make:migration create_portfolio_items_table
```

```php
<?php
// database/migrations/xxxx_create_portfolio_items_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('category');              // CNC Turning, Milling, Welding…
            $table->string('material')->nullable();  // e.g., AISI 304 Stainless Steel
            $table->string('tolerance')->nullable(); // e.g., ±0.01 mm
            $table->string('client_name')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_items');
    }
};
```

### 5.3 Certifications Table

```bash
./vendor/bin/sail php artisan make:migration create_certifications_table
```

```php
<?php
// database/migrations/xxxx_create_certifications_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->string('name');                       // ISO 9001:2015
            $table->string('issuer');                     // Bureau Veritas
            $table->string('certificate_number')->nullable();
            $table->date('issued_at');
            $table->date('expires_at')->nullable();
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certifications');
    }
};
```

### 5.4 Clients Table

```bash
./vendor/bin/sail php artisan make:migration create_clients_table
```

```php
<?php
// database/migrations/xxxx_create_clients_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('industry')->nullable();       // Automotive, Oil & Gas…
            $table->string('website')->nullable();
            $table->text('testimonial')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_role')->nullable();   // Procurement Manager…
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
```

### 5.5 Site Settings Table

```bash
./vendor/bin/sail php artisan make:migration create_site_settings_table
```

```php
<?php
// database/migrations/xxxx_create_site_settings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general'); // general, hero, contact, social
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
```

### 5.6 Run All Migrations

```bash
./vendor/bin/sail php artisan migrate
```

---

## 6. Eloquent Models

### 6.1 Service Model

```bash
./vendor/bin/sail php artisan make:model Service
```

```php
<?php
// app/Models/Service.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Service extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title', 'subtitle', 'description',
        'icon', 'slug', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Service $model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('gallery')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(400)->height(300)->sharpen(10)->queued();

        $this->addMediaConversion('card')
            ->width(800)->height(600)->queued();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
```

### 6.2 PortfolioItem Model

```bash
./vendor/bin/sail php artisan make:model PortfolioItem
```

```php
<?php
// app/Models/PortfolioItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PortfolioItem extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title', 'subtitle', 'description', 'category',
        'material', 'tolerance', 'client_name',
        'sort_order', 'is_featured', 'is_active',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('gallery')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(500)->height(400)->queued();

        $this->addMediaConversion('full')
            ->width(1200)->height(900)->queued();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('is_active', true);
    }
}
```

### 6.3 Certification Model

```bash
./vendor/bin/sail php artisan make:model Certification
```

```php
<?php
// app/Models/Certification.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Certification extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name', 'issuer', 'certificate_number',
        'issued_at', 'expires_at', 'description',
        'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'issued_at'  => 'date',
        'expires_at' => 'date',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('certificate')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'application/pdf']);

        $this->addMediaCollection('logo')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)->height(200)->queued();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }
}
```

### 6.4 Client Model

```bash
./vendor/bin/sail php artisan make:model Client
```

```php
<?php
// app/Models/Client.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Client extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name', 'industry', 'website',
        'testimonial', 'contact_name', 'contact_role',
        'is_featured', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(200)->height(100)->queued();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('is_active', true);
    }
}
```

---

## 7. Filament v5 Admin Panel Setup

### 7.1 Create Admin User

```bash
./vendor/bin/sail php artisan make:filament-user
# Name:     Admin
# Email:    admin@precision.com
# Password: (strong password)
```

### 7.2 Configure `AdminPanelProvider`

```php
<?php
// app/Providers/Filament/AdminPanelProvider.php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors(['primary' => Color::Blue])
            ->brandName('Precision Machining — Admin')
            ->favicon(asset('images/favicon.png'))
            ->discoverResources(
                in: app_path('Filament/Resources'),
                for: 'App\\Filament\\Resources'
            )
            ->discoverPages(
                in: app_path('Filament/Pages'),
                for: 'App\\Filament\\Pages'
            )
            ->pages([Pages\Dashboard::class])
            ->discoverWidgets(
                in: app_path('Filament/Widgets'),
                for: 'App\\Filament\\Widgets'
            )
            ->widgets([Widgets\AccountWidget::class])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([Authenticate::class]);
    }
}
```

---

## 8. Filament Resources

> **Filament v5 note:** The Forms, Tables and Actions API is identical to v4.
> The major change is that Livewire v4 runs underneath. Existing v4 resource code
> works in v5 without modification beyond the automated upgrade script.

### 8.1 ServiceResource

```bash
./vendor/bin/sail php artisan make:filament-resource Service --generate
```

```php
<?php
// app/Filament/Resources/ServiceResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Support\Str;

class ServiceResource extends Resource
{
    protected static ?string $model           = Service::class;
    protected static ?string $navigationIcon  = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationGroup = 'Website Content';
    protected static ?int    $navigationSort  = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('Basic Information')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (string $op, $state, Forms\Set $set) =>
                            $op === 'create' ? $set('slug', Str::slug($state)) : null
                        ),

                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),

                    Forms\Components\TextInput::make('subtitle')
                        ->maxLength(255),

                    Forms\Components\RichEditor::make('description')
                        ->required()
                        ->columnSpanFull()
                        ->toolbarButtons([
                            'bold', 'italic', 'bulletList', 'orderedList', 'h2', 'h3', 'link',
                        ]),

                    Forms\Components\TextInput::make('icon')
                        ->placeholder('heroicon-o-wrench-screwdriver')
                        ->helperText('Heroicon name (e.g. heroicon-o-fire)'),

                    Forms\Components\TextInput::make('sort_order')
                        ->numeric()->default(0),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Visible on website')
                        ->default(true),
                ])
                ->columns(2),

            Forms\Components\Section::make('Cover Image')
                ->schema([
                    SpatieMediaLibraryFileUpload::make('cover')
                        ->collection('cover')
                        ->image()
                        ->imageEditor()
                        ->maxSize(5120)
                        ->helperText('Recommended: 800×600 px · Max 5 MB'),
                ]),

            Forms\Components\Section::make('Gallery Images')
                ->schema([
                    SpatieMediaLibraryFileUpload::make('gallery')
                        ->collection('gallery')
                        ->image()
                        ->multiple()
                        ->reorderable()
                        ->maxSize(5120)
                        ->maxFiles(10),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('cover')
                    ->collection('cover')->conversion('thumb')
                    ->width(60)->height(45),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()->sortable(),

                Tables\Columns\TextColumn::make('subtitle')
                    ->limit(40)->placeholder('—'),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()->label('Active'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d/m/Y H:i')->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit'   => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
```

### 8.2 PortfolioItemResource

```bash
./vendor/bin/sail php artisan make:filament-resource PortfolioItem --generate
```

```php
<?php
// app/Filament/Resources/PortfolioItemResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\PortfolioItemResource\Pages;
use App\Models\PortfolioItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class PortfolioItemResource extends Resource
{
    protected static ?string $model           = PortfolioItem::class;
    protected static ?string $navigationIcon  = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Website Content';
    protected static ?string $navigationLabel = 'Portfolio';
    protected static ?int    $navigationSort  = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('Item Details')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()->maxLength(255),

                    Forms\Components\TextInput::make('subtitle')
                        ->maxLength(255),

                    Forms\Components\Select::make('category')
                        ->options([
                            'CNC Turning' => 'CNC Turning',
                            'CNC Milling' => 'CNC Milling',
                            'Welding'     => 'Welding',
                            'Finishing'   => 'Finishing',
                            'Assembly'    => 'Assembly',
                        ])
                        ->required()->searchable(),

                    Forms\Components\TextInput::make('material')
                        ->placeholder('e.g., AISI 304 Stainless Steel'),

                    Forms\Components\TextInput::make('tolerance')
                        ->placeholder('e.g., ±0.01 mm'),

                    Forms\Components\TextInput::make('client_name')
                        ->label('Client (optional)'),

                    Forms\Components\Textarea::make('description')
                        ->rows(4)->columnSpanFull(),

                    Forms\Components\TextInput::make('sort_order')
                        ->numeric()->default(0),

                    Forms\Components\Toggle::make('is_featured')
                        ->label('Featured on homepage'),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Active')->default(true),
                ])
                ->columns(2),

            Forms\Components\Section::make('Cover Photo')
                ->schema([
                    SpatieMediaLibraryFileUpload::make('cover')
                        ->collection('cover')
                        ->image()->imageEditor()->maxSize(5120),
                ]),

            Forms\Components\Section::make('Gallery Photos')
                ->schema([
                    SpatieMediaLibraryFileUpload::make('gallery')
                        ->collection('gallery')
                        ->image()->multiple()->reorderable()
                        ->maxSize(5120)->maxFiles(20),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('cover')
                    ->collection('cover')->conversion('thumb')
                    ->width(70)->height(50),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()->sortable(),

                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'CNC Turning' => 'primary',
                        'CNC Milling' => 'success',
                        'Welding'     => 'warning',
                        'Finishing'   => 'info',
                        default       => 'gray',
                    }),

                Tables\Columns\TextColumn::make('material')->limit(30)->placeholder('—'),
                Tables\Columns\TextColumn::make('tolerance')->placeholder('—'),
                Tables\Columns\IconColumn::make('is_featured')->boolean()->label('Featured'),
                Tables\Columns\IconColumn::make('is_active')->boolean()->label('Active'),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'CNC Turning' => 'CNC Turning',
                        'CNC Milling' => 'CNC Milling',
                        'Welding'     => 'Welding',
                        'Finishing'   => 'Finishing',
                        'Assembly'    => 'Assembly',
                    ]),
                Tables\Filters\TernaryFilter::make('is_featured'),
                Tables\Filters\TernaryFilter::make('is_active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPortfolioItems::route('/'),
            'create' => Pages\CreatePortfolioItem::route('/create'),
            'edit'   => Pages\EditPortfolioItem::route('/{record}/edit'),
        ];
    }
}
```

### 8.3 CertificationResource

```bash
./vendor/bin/sail php artisan make:filament-resource Certification --generate
```

```php
<?php
// app/Filament/Resources/CertificationResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\CertificationResource\Pages;
use App\Models\Certification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class CertificationResource extends Resource
{
    protected static ?string $model           = Certification::class;
    protected static ?string $navigationIcon  = 'heroicon-o-shield-check';
    protected static ?string $navigationGroup = 'Website Content';
    protected static ?int    $navigationSort  = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('Certificate Information')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()->placeholder('e.g., ISO 9001:2015'),

                    Forms\Components\TextInput::make('issuer')
                        ->required()->placeholder('e.g., Bureau Veritas'),

                    Forms\Components\TextInput::make('certificate_number')
                        ->placeholder('e.g., BR-12345-2025'),

                    Forms\Components\DatePicker::make('issued_at')
                        ->required()->label('Issue Date')->displayFormat('d/m/Y'),

                    Forms\Components\DatePicker::make('expires_at')
                        ->label('Expiration Date')->displayFormat('d/m/Y')
                        ->helperText('Leave blank if the certificate does not expire'),

                    Forms\Components\Textarea::make('description')
                        ->rows(3)->columnSpanFull(),

                    Forms\Components\TextInput::make('sort_order')
                        ->numeric()->default(0),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Active')->default(true),
                ])
                ->columns(2),

            Forms\Components\Section::make('Certificate Document / Image')
                ->schema([
                    SpatieMediaLibraryFileUpload::make('certificate')
                        ->collection('certificate')
                        ->image()
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'application/pdf'])
                        ->maxSize(10240)
                        ->helperText('Upload scan or PDF · Max 10 MB'),
                ]),

            Forms\Components\Section::make('Issuer Logo')
                ->schema([
                    SpatieMediaLibraryFileUpload::make('logo')
                        ->collection('logo')
                        ->image()
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'])
                        ->maxSize(2048)
                        ->helperText('SVG preferred · Max 2 MB'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('logo')
                    ->collection('logo')->conversion('thumb')
                    ->width(60)->height(40),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()->sortable()->weight('bold'),

                Tables\Columns\TextColumn::make('issuer')->searchable(),
                Tables\Columns\TextColumn::make('certificate_number')->placeholder('—'),

                Tables\Columns\TextColumn::make('issued_at')
                    ->date('d/m/Y')->sortable(),

                Tables\Columns\TextColumn::make('expires_at')
                    ->date('d/m/Y')
                    ->placeholder('No expiration')
                    ->color(fn ($record) => $record?->isExpired() ? 'danger' : 'success'),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()->label('Active'),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCertifications::route('/'),
            'create' => Pages\CreateCertification::route('/create'),
            'edit'   => Pages\EditCertification::route('/{record}/edit'),
        ];
    }
}
```

### 8.4 ClientResource

```bash
./vendor/bin/sail php artisan make:filament-resource Client --generate
```

```php
<?php
// app/Filament/Resources/ClientResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class ClientResource extends Resource
{
    protected static ?string $model           = Client::class;
    protected static ?string $navigationIcon  = 'heroicon-o-building-office';
    protected static ?string $navigationGroup = 'Website Content';
    protected static ?int    $navigationSort  = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('Client Information')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()->maxLength(255),

                    Forms\Components\TextInput::make('industry')
                        ->placeholder('e.g., Automotive, Oil & Gas, Aerospace'),

                    Forms\Components\TextInput::make('website')
                        ->url()->placeholder('https://client.com'),

                    Forms\Components\TextInput::make('sort_order')
                        ->numeric()->default(0),

                    Forms\Components\Toggle::make('is_featured')
                        ->label('Show testimonial on homepage'),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Active')->default(true),
                ])
                ->columns(2),

            Forms\Components\Section::make('Testimonial')
                ->schema([
                    Forms\Components\Textarea::make('testimonial')
                        ->rows(4)->columnSpanFull(),

                    Forms\Components\TextInput::make('contact_name')
                        ->label('Contact Name'),

                    Forms\Components\TextInput::make('contact_role')
                        ->label('Contact Role')
                        ->placeholder('e.g., Procurement Manager'),
                ])
                ->columns(2),

            Forms\Components\Section::make('Client Logo')
                ->schema([
                    SpatieMediaLibraryFileUpload::make('logo')
                        ->collection('logo')
                        ->image()->imageEditor()
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'])
                        ->maxSize(2048)
                        ->helperText('PNG transparent or SVG preferred · Max 2 MB'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('logo')
                    ->collection('logo')->conversion('thumb')
                    ->width(80)->height(40),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()->sortable(),

                Tables\Columns\TextColumn::make('industry')->placeholder('—'),

                Tables\Columns\TextColumn::make('testimonial')
                    ->limit(50)->placeholder('No testimonial'),

                Tables\Columns\TextColumn::make('contact_name')->placeholder('—'),

                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()->label('Featured'),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()->label('Active'),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_featured'),
                Tables\Filters\TernaryFilter::make('is_active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit'   => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
```

---

## 9. TallStackUI v3 Frontend Setup

### 9.1 Main Layout with TallStackUI

TallStackUI v3 requires `<tallstackui:script />` before `@vite`, and `<x-toast />`
plus `<x-dialog />` somewhere in the body. Alpine.js is bundled into Livewire v4.

```blade
{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('description', 'Industrial CNC Machining. ISO 9001 certified.')">

    {{-- TallStackUI styles — must come before @vite --}}
    <tallstackui:script />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-white text-gray-900 antialiased">

    {{-- TallStackUI global interaction components --}}
    <x-toast />
    <x-dialog />

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    @livewireScripts
    @stack('scripts')
</body>
</html>
```

### 9.2 Navbar Partial with TallStackUI Components

```blade
{{-- resources/views/partials/navbar.blade.php --}}
<nav class="bg-blue-900 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 flex items-center justify-between h-16">

        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="h-8 w-auto">
            <span class="text-white font-medium text-sm hidden md:block">Precision Machining</span>
        </a>

        <div class="hidden md:flex items-center gap-6">
            <x-link href="{{ route('home') }}"                color="white" text="Home" />
            <x-link href="{{ route('services.index') }}"      color="white" text="Services" />
            <x-link href="{{ route('portfolio.index') }}"     color="white" text="Portfolio" />
            <x-link href="{{ route('certifications.index') }}" color="white" text="Certifications" />
            <x-link href="{{ route('contact') }}"             color="white" text="Contact" />
        </div>

        <x-button
            href="{{ route('contact') }}"
            color="white"
            text="Request Quote"
            class="hidden md:inline-flex rounded-full text-blue-800 font-medium text-sm"
        />

        <div class="md:hidden" x-data="{ open: false }">
            <button @click="open = !open" class="text-white p-1">
                <x-icon name="bars-3" class="w-6 h-6" />
            </button>
            <div x-show="open" x-transition
                 class="absolute top-16 left-0 right-0 bg-blue-900 px-6 py-4 flex flex-col gap-4 shadow-xl">
                <x-link href="{{ route('home') }}"                color="white" text="Home" />
                <x-link href="{{ route('services.index') }}"      color="white" text="Services" />
                <x-link href="{{ route('portfolio.index') }}"     color="white" text="Portfolio" />
                <x-link href="{{ route('certifications.index') }}" color="white" text="Certifications" />
                <x-link href="{{ route('contact') }}"             color="white" text="Contact" />
            </div>
        </div>

    </div>
</nav>
```

---

## 10. Livewire Components (Frontend)

Livewire v4 introduces **single-file components (SFC)** — PHP and Blade in one file.
Each component below uses this format. The `new class extends Component` block
sits at the top of the `.blade.php` file between `<?php ... ?>` tags.

### 10.1 Services Section Component

```bash
./vendor/bin/sail php artisan make:livewire ServicesSection
```

```blade
{{-- resources/views/livewire/services-section.blade.php --}}
<?php

use App\Models\Service;
use Livewire\Component;

new class extends Component
{
    public function render()
    {
        return view('livewire.services-section', [
            'services' => Service::active()->take(4)->get(),
        ]);
    }
};

?>

<section id="services" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">

        <p class="text-xs font-medium tracking-widest text-blue-500 uppercase mb-2">Our Services</p>
        <h2 class="text-3xl font-medium text-blue-900 mb-12">Complete industrial capability</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($services as $service)
            <x-card class="border border-blue-100 border-t-4 border-t-blue-500 hover:shadow-md transition">
                @if ($service->getFirstMedia('cover'))
                <img src="{{ $service->getFirstMediaUrl('cover', 'thumb') }}"
                     alt="{{ $service->title }}"
                     class="w-full h-36 object-cover rounded-lg mb-4">
                @endif

                <h3 class="text-sm font-medium text-blue-900 mb-1">{{ $service->title }}</h3>

                @if ($service->subtitle)
                <x-badge color="primary" text="{{ $service->subtitle }}" class="mb-3" />
                @endif

                <p class="text-sm text-gray-500 leading-relaxed line-clamp-3">
                    {!! strip_tags($service->description) !!}
                </p>
            </x-card>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <x-button
                href="{{ route('services.index') }}"
                color="primary"
                text="View all services"
                outline
                class="rounded-full px-8"
            />
        </div>
    </div>
</section>
```

### 10.2 Portfolio Grid Component (with live category filter)

```bash
./vendor/bin/sail php artisan make:livewire PortfolioGrid
```

```blade
{{-- resources/views/livewire/portfolio-grid.blade.php --}}
<?php

use App\Models\PortfolioItem;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public string $category = '';

    public function updatedCategory(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $items = PortfolioItem::active()
            ->when($this->category, fn ($q) => $q->where('category', $this->category))
            ->paginate(12);

        $categories = PortfolioItem::active()
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('livewire.portfolio-grid', compact('items', 'categories'));
    }
};

?>

<section id="portfolio" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">

        <p class="text-xs font-medium tracking-widest text-blue-500 uppercase mb-2">Portfolio</p>
        <h2 class="text-3xl font-medium text-blue-900 mb-8">Featured work</h2>

        {{-- Category filter — TallStackUI x-select with live binding --}}
        <div class="mb-8 max-w-xs">
            <x-select
                wire:model.live="category"
                label="Filter by category"
                :options="$categories->prepend('All categories')->map(fn ($c) => [
                    'label' => $c,
                    'value' => $c === 'All categories' ? '' : $c,
                ])->values()->toArray()"
                option-label="label"
                option-value="value"
            />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($items as $item)
            <x-card class="overflow-hidden border border-blue-100 hover:shadow-lg transition p-0">

                @if ($item->getFirstMedia('cover'))
                <img src="{{ $item->getFirstMediaUrl('cover', 'thumb') }}"
                     alt="{{ $item->title }}"
                     class="w-full h-48 object-cover">
                @else
                <div class="w-full h-48 bg-blue-50 flex items-center justify-center">
                    <x-icon name="photo" class="w-10 h-10 text-blue-200" />
                </div>
                @endif

                <div class="p-5">
                    <x-badge color="primary" text="{{ $item->category }}" class="mb-3" />
                    <h3 class="text-sm font-medium text-blue-900 mb-2">{{ $item->title }}</h3>
                    @if ($item->material)
                    <p class="text-xs text-gray-500">Material: {{ $item->material }}</p>
                    @endif
                    @if ($item->tolerance)
                    <p class="text-xs text-gray-500">Tolerance: {{ $item->tolerance }}</p>
                    @endif
                </div>
            </x-card>
            @empty
            <div class="col-span-3 py-16 text-center">
                <x-icon name="photo" class="w-12 h-12 text-blue-100 mx-auto mb-3" />
                <p class="text-gray-400 text-sm">No portfolio items found for this category.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-8">{{ $items->links() }}</div>
    </div>
</section>
```

### 10.3 Certifications Section Component

```bash
./vendor/bin/sail php artisan make:livewire CertsSection
```

```blade
{{-- resources/views/livewire/certs-section.blade.php --}}
<?php

use App\Models\Certification;
use Livewire\Component;

new class extends Component
{
    public function render()
    {
        return view('livewire.certs-section', [
            'certifications' => Certification::active()->get(),
        ]);
    }
};

?>

<section id="certifications" class="py-20 bg-blue-900">
    <div class="max-w-7xl mx-auto px-6">

        <p class="text-xs font-medium tracking-widest text-blue-300 uppercase mb-2">Certifications</p>
        <h2 class="text-3xl font-medium text-white mb-12">Quality management certified</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($certifications as $cert)
            <div class="bg-white/10 border border-white/10 rounded-xl p-6">

                @if ($cert->getFirstMedia('logo'))
                <img src="{{ $cert->getFirstMediaUrl('logo', 'thumb') }}"
                     alt="{{ $cert->issuer }}"
                     class="h-10 object-contain mb-4 opacity-80">
                @endif

                <h3 class="text-lg font-medium text-white mb-1">{{ $cert->name }}</h3>
                <p class="text-sm text-blue-300 mb-3">{{ $cert->issuer }}</p>

                @if ($cert->certificate_number)
                <p class="text-xs text-blue-400">No: {{ $cert->certificate_number }}</p>
                @endif

                <p class="text-xs text-blue-400">
                    Issued: {{ $cert->issued_at->format('d/m/Y') }}
                </p>

                @if ($cert->expires_at)
                <x-badge
                    :color="$cert->isExpired() ? 'red' : 'green'"
                    :text="'Expires: ' . $cert->expires_at->format('d/m/Y')"
                    class="mt-2"
                />
                @endif

                @if ($cert->description)
                <p class="text-sm text-blue-200 mt-3 leading-relaxed">
                    {{ $cert->description }}
                </p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
```

### 10.4 Clients Section Component

```bash
./vendor/bin/sail php artisan make:livewire ClientsSection
```

```blade
{{-- resources/views/livewire/clients-section.blade.php --}}
<?php

use App\Models\Client;
use Livewire\Component;

new class extends Component
{
    public function render()
    {
        return view('livewire.clients-section', [
            'clients'         => Client::active()->get(),
            'featuredClients' => Client::featured()->take(3)->get(),
        ]);
    }
};

?>

<section id="clients" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">

        <p class="text-xs font-medium tracking-widest text-blue-500 uppercase mb-2">Clients</p>
        <h2 class="text-3xl font-medium text-blue-900 mb-12">Trusted by industry leaders</h2>

        {{-- Logo strip --}}
        <div class="flex flex-wrap items-center justify-center gap-8 mb-16">
            @foreach ($clients as $client)
                @if ($client->getFirstMedia('logo'))
                <x-tooltip :text="$client->name">
                    <img src="{{ $client->getFirstMediaUrl('logo', 'thumb') }}"
                         alt="{{ $client->name }}"
                         class="h-10 object-contain grayscale hover:grayscale-0 opacity-60 hover:opacity-100 transition">
                </x-tooltip>
                @else
                <span class="text-sm text-gray-400 font-medium">{{ $client->name }}</span>
                @endif
            @endforeach
        </div>

        {{-- Featured testimonials --}}
        @if ($featuredClients->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($featuredClients as $client)
            @if ($client->testimonial)
            <x-card class="bg-blue-50 border border-blue-100 flex flex-col">
                <x-rating :score="5" read-only class="mb-3" />

                <p class="text-sm text-gray-600 leading-relaxed italic mb-4">
                    "{{ $client->testimonial }}"
                </p>

                <div class="flex items-center gap-3 mt-auto pt-4 border-t border-blue-100">
                    @if ($client->getFirstMedia('logo'))
                    <img src="{{ $client->getFirstMediaUrl('logo', 'thumb') }}"
                         alt="{{ $client->name }}" class="h-8 object-contain">
                    @endif
                    <div>
                        @if ($client->contact_name)
                        <p class="text-sm font-medium text-blue-900">{{ $client->contact_name }}</p>
                        @endif
                        <p class="text-xs text-blue-500">
                            {{ $client->contact_role ? $client->contact_role . ' · ' : '' }}{{ $client->name }}
                        </p>
                    </div>
                </div>
            </x-card>
            @endif
            @endforeach
        </div>
        @endif
    </div>
</section>
```

### 10.5 Quote Request Form Component

```bash
./vendor/bin/sail php artisan make:livewire QuoteForm
```

```blade
{{-- resources/views/livewire/quote-form.blade.php --}}
<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

new class extends Component
{
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|email|max:255')]
    public string $email = '';

    #[Validate('nullable|string|max:20')]
    public string $phone = '';

    #[Validate('required|string|max:2000')]
    public string $message = '';

    #[Validate('nullable|file|mimes:pdf,dwg,dxf,step,stp|max:20480')]
    public $file = null;

    public bool $sent = false;

    public function submit(): void
    {
        $this->validate();

        // TODO: Mail::to(config('mail.quote_recipient'))->send(new QuoteRequestMail($this->all()));

        $this->reset(['name', 'email', 'phone', 'message', 'file']);
        $this->sent = true;

        $this->dispatch('toast', message: 'Quote request sent! We respond within 24 hours.', type: 'success');
    }

    public function render()
    {
        return view('livewire.quote-form');
    }
};

?>

<x-card class="max-w-2xl mx-auto">

    @if ($sent)
        <x-alert color="green"
                 title="Request sent successfully!"
                 text="Our team will contact you within 24 hours." />
    @else

    <h2 class="text-xl font-medium text-blue-900 mb-6">Request a Quote</h2>

    <div class="flex flex-col gap-4">

        <x-input
            wire:model="name"
            label="Full name *"
            placeholder="Your name"
            :error="$errors->first('name')"
        />

        <x-input
            wire:model="email"
            type="email"
            label="Email *"
            placeholder="your@email.com"
            :error="$errors->first('email')"
        />

        <x-input
            wire:model="phone"
            label="Phone"
            placeholder="+55 11 99999-9999"
            :error="$errors->first('phone')"
        />

        <x-textarea
            wire:model="message"
            label="Project description *"
            placeholder="Describe the part, material, tolerance, quantity..."
            rows="4"
            :error="$errors->first('message')"
        />

        <x-upload
            wire:model="file"
            label="Technical drawing (optional)"
            accept=".pdf,.dwg,.dxf,.step,.stp"
            hint="PDF, DWG, DXF or STEP · Max 20 MB"
            :error="$errors->first('file')"
        />

        <x-button
            wire:click="submit"
            wire:loading.attr="disabled"
            color="primary"
            text="Send Request"
            class="rounded-full w-full justify-center mt-2"
        />

    </div>
    @endif
</x-card>
```

---

## 11. Frontend Routes & Controllers

```php
<?php
// routes/web.php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\CertificationController;
use Illuminate\Support\Facades\Route;

Route::get('/',                [HomeController::class, 'index'])->name('home');
Route::get('/services',        [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/portfolio',       [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/certifications',  [CertificationController::class, 'index'])->name('certifications.index');
Route::get('/contact',         fn () => view('contact'))->name('contact');
```

```php
<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        // All dynamic sections are loaded by embedded Livewire components.
        return view('home');
    }
}
```

```php
<?php
// app/Http/Controllers/ServiceController.php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::active()->get();
        return view('services.index', compact('services'));
    }

    public function show(string $slug)
    {
        $service = Service::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $others  = Service::active()->where('id', '!=', $service->id)->take(3)->get();
        return view('services.show', compact('service', 'others'));
    }
}
```

```php
<?php
// app/Http/Controllers/CertificationController.php

namespace App\Http\Controllers;

use App\Models\Certification;

class CertificationController extends Controller
{
    public function index()
    {
        $certifications = Certification::active()->get();
        return view('certifications.index', compact('certifications'));
    }
}
```

---

## 12. Blade Views with TallStackUI

### 12.1 Home View

```blade
{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('title', 'Industrial CNC Machining — Precision Machining')
@section('description', 'ISO 9001 certified CNC turning, milling, welding and finishing.')

@section('content')

    {{-- HERO --}}
    <section class="bg-blue-900 relative overflow-hidden flex items-center min-h-80">
        <div class="absolute inset-0 opacity-5"
             style="background-image:
                repeating-linear-gradient(0deg,#fff 0,#fff 1px,transparent 1px,transparent 48px),
                repeating-linear-gradient(90deg,#fff 0,#fff 1px,transparent 1px,transparent 48px)">
        </div>
        <div class="relative max-w-7xl mx-auto px-6 py-20 z-10">
            <x-badge color="blue" text="ISO 9001:2015 Certified" class="mb-5" />
            <h1 class="text-4xl font-medium text-white leading-tight mb-4">
                Precision that moves<br>
                <span class="text-blue-300">Brazilian industry</span><br>
                since 2005.
            </h1>
            <p class="text-blue-200 text-base max-w-lg mb-8 leading-relaxed">
                CNC turning, milling, welding and finishing with tolerances to ±0.01 mm.
                Full traceability and certified quality in every delivery.
            </p>
            <div class="flex gap-3 flex-wrap">
                <x-button href="{{ route('services.index') }}"
                          color="primary" text="Our Services" class="rounded-full" />
                <x-button href="{{ route('contact') }}"
                          color="white" text="Talk to a Specialist"
                          outline class="rounded-full text-white border-white/40" />
            </div>
        </div>
    </section>

    {{-- STATS STRIP --}}
    <div class="bg-blue-500">
        <div class="max-w-7xl mx-auto px-6">
            <x-stats
                :items="[
                    ['label' => 'Parts / month',   'value' => '+800'],
                    ['label' => 'Tolerance',        'value' => '±0.01 mm'],
                    ['label' => 'Years on market',  'value' => '20'],
                    ['label' => 'Quality standard', 'value' => 'ISO 9001'],
                ]"
                color="white"
                class="py-4"
            />
        </div>
    </div>

    {{-- DYNAMIC SECTIONS — all loaded by Livewire v4 components --}}
    <livewire:services-section />
    <livewire:certs-section />
    <livewire:clients-section />

    {{-- CTA --}}
    <section class="bg-blue-500 py-16">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h2 class="text-2xl font-medium text-white mb-1">Ready to start your project?</h2>
                <p class="text-blue-100 text-sm">Send the technical drawing and get a quote in 24 hours.</p>
            </div>
            <div class="flex gap-3">
                <x-button href="{{ route('contact') }}"
                          color="white" text="Request Quote"
                          class="rounded-full text-blue-700 font-medium" />
                <x-button href="https://wa.me/5511999999999"
                          color="white" text="WhatsApp"
                          outline class="rounded-full text-white border-white/50" />
            </div>
        </div>
    </section>

@endsection
```

### 12.2 Portfolio Page

```blade
{{-- resources/views/portfolio/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Portfolio — Precision Machining')

@section('content')
    <div class="bg-blue-900 py-14">
        <div class="max-w-7xl mx-auto px-6">
            <p class="text-xs text-blue-300 tracking-widest uppercase mb-2">Portfolio</p>
            <h1 class="text-3xl font-medium text-white">Our completed work</h1>
        </div>
    </div>

    {{-- Livewire component handles category filter + pagination reactively --}}
    <livewire:portfolio-grid />
@endsection
```

### 12.3 Contact Page

```blade
{{-- resources/views/contact.blade.php --}}
@extends('layouts.app')
@section('title', 'Request a Quote — Precision Machining')

@section('content')
    <div class="bg-blue-900 py-14">
        <div class="max-w-7xl mx-auto px-6">
            <h1 class="text-3xl font-medium text-white">Request a Quote</h1>
            <p class="text-blue-300 mt-2 text-sm">
                Send us your technical drawing. We respond within 24 hours.
            </p>
        </div>
    </div>

    <div class="py-16 max-w-7xl mx-auto px-6">
        <livewire:quote-form />
    </div>
@endsection
```

---

## 13. Seeders

```php
<?php
// database/seeders/ServiceSeeder.php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title'       => 'CNC Turning',
                'subtitle'    => 'High-precision rotational parts',
                'description' => 'CNC turning for steel, aluminium and special alloys. Tolerances down to ±0.01 mm.',
                'icon'        => 'heroicon-o-arrow-path',
                'sort_order'  => 1,
            ],
            [
                'title'       => 'CNC Milling',
                'subtitle'    => '3-axis complex geometries',
                'description' => '3-axis CNC milling for complex profiles, pockets, cavities and flat surfaces.',
                'icon'        => 'heroicon-o-squares-2x2',
                'sort_order'  => 2,
            ],
            [
                'title'       => 'Welding',
                'subtitle'    => 'MIG, TIG and arc welding',
                'description' => 'Qualified welding procedures for structural and precision assemblies.',
                'icon'        => 'heroicon-o-fire',
                'sort_order'  => 3,
            ],
            [
                'title'       => 'Quality Control',
                'subtitle'    => 'Dimensional inspection & traceable reports',
                'description' => 'Full dimensional inspection with calibrated instruments and traceable report.',
                'icon'        => 'heroicon-o-shield-check',
                'sort_order'  => 4,
            ],
        ];

        foreach ($services as $data) {
            Service::firstOrCreate(
                ['slug' => Str::slug($data['title'])],
                array_merge($data, ['is_active' => true])
            );
        }
    }
}
```

```php
<?php
// database/seeders/CertificationSeeder.php

namespace Database\Seeders;

use App\Models\Certification;
use Illuminate\Database\Seeder;

class CertificationSeeder extends Seeder
{
    public function run(): void
    {
        Certification::firstOrCreate(
            ['name' => 'ISO 9001:2015'],
            [
                'issuer'             => 'Bureau Veritas',
                'certificate_number' => 'BR-12345-2025',
                'issued_at'          => '2022-03-15',
                'expires_at'         => '2025-03-14',
                'description'        => 'Quality management system for CNC machining and welding processes.',
                'sort_order'         => 1,
                'is_active'          => true,
            ]
        );
    }
}
```

```php
<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@precision.com'],
            ['name' => 'Admin', 'password' => bcrypt('Admin@2025!')]
        );

        $this->call([
            ServiceSeeder::class,
            CertificationSeeder::class,
        ]);
    }
}
```

```bash
./vendor/bin/sail php artisan db:seed
```

---

## 14. Final Checklist

### Environment & Installation

- [ ] Laravel 12 project created
- [ ] Sail running with PostgreSQL (`./vendor/bin/sail up -d`)
- [ ] Livewire v4 installed (`livewire/livewire:"^4.0"`)
- [ ] Filament v5 installed (`filament/filament:"^5.3"`)
- [ ] Spatie Media Library v11 installed + migrations published
- [ ] Filament Spatie plugin installed (`filament/spatie-laravel-media-library-plugin:"^5.3"`)
- [ ] TallStackUI v3 installed (`tallstackui/tallstackui:"^3.0"`)
- [ ] `php artisan tallstackui:install` executed
- [ ] TailwindCSS v4 installed (`@tailwindcss/vite`)
- [ ] `vite.config.js` updated with `@tailwindcss/vite` plugin
- [ ] `resources/css/app.css` — `@import "tailwindcss"` + `@source` for TallStackUI + `@theme` tokens
- [ ] `config/tallstackui.php` published and configured
- [ ] Storage symlink created (`php artisan storage:link`)
- [ ] `.env` — DB, APP_URL, FILESYSTEM_DISK=public, QUEUE_CONNECTION=database

### Database

- [ ] Migration: `services`
- [ ] Migration: `portfolio_items`
- [ ] Migration: `certifications`
- [ ] Migration: `clients`
- [ ] Migration: `site_settings`
- [ ] Spatie `media` table migration run
- [ ] All migrations executed (`php artisan migrate`)

### Models (Spatie Media Library)

- [ ] `Service` — collections: `cover` (single), `gallery` (multiple)
- [ ] `PortfolioItem` — collections: `cover` (single), `gallery` (multiple)
- [ ] `Certification` — collections: `certificate` (single), `logo` (single)
- [ ] `Client` — collection: `logo` (single)

### Filament v5 Admin

- [ ] Admin user created (`php artisan make:filament-user`)
- [ ] `AdminPanelProvider` — blue color theme, `discoverResources`
- [ ] `ServiceResource` — Spatie upload (cover + gallery), RichEditor, reorderable table
- [ ] `PortfolioItemResource` — category badge filter, featured toggle
- [ ] `CertificationResource` — date pickers, PDF upload, expiry color on table
- [ ] `ClientResource` — testimonial section, logo upload, featured toggle
- [ ] All resources under `navigationGroup = 'Website Content'`

### TallStackUI v3 Frontend

- [ ] Layout: `<tallstackui:script />` before `@vite`
- [ ] Layout: `<x-toast />` and `<x-dialog />` in body
- [ ] Navbar: `<x-link>`, `<x-button>`, `<x-icon>`, Alpine `x-show` for mobile menu
- [ ] `ServicesSection` SFC — `<x-card>`, `<x-badge>`, `<x-button>`
- [ ] `PortfolioGrid` SFC — `<x-select wire:model.live>`, `<x-badge>`, `<x-icon>`, pagination
- [ ] `CertsSection` SFC — `<x-badge>` for expiry status (red/green)
- [ ] `ClientsSection` SFC — `<x-tooltip>`, `<x-rating>`, `<x-card>`
- [ ] `QuoteForm` SFC — `<x-input>`, `<x-textarea>`, `<x-upload>`, `<x-button>`, `<x-alert>`
- [ ] Home embeds all components via `<livewire:services-section />` etc.
- [ ] Portfolio page delegates to `<livewire:portfolio-grid />`

### Image Pipeline

- [ ] `FILESYSTEM_DISK=public` in `.env`
- [ ] `QUEUE_CONNECTION=database` in `.env`
- [ ] Queue table migration run (`php artisan queue:table && php artisan migrate`)
- [ ] Queue worker running (`php artisan queue:work`)
- [ ] Conversions registered per model: `thumb`, `card`, `full`

### Build & Production

- [ ] `npm run build` — TailwindCSS v4 + Vite build passes
- [ ] No style conflict between TallStackUI (frontend) and Filament (admin under `/admin`)
- [ ] `php artisan optimize`
- [ ] `php artisan storage:link`
- [ ] `php artisan filament:optimize-clear`
- [ ] Queue worker managed with Supervisor in production

---

> **Admin panel URL:** `https://your-domain.com/admin`
>
> **Tech Stack:**
> Laravel 12 · Filament v5.3 · Livewire v4 · TallStackUI v3 · TailwindCSS v4 ·
> Spatie Media Library v11 · PostgreSQL · Laravel Sail
