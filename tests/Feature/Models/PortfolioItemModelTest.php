<?php

use App\Models\PortfolioItem;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('creates a portfolio item with all fields', function () {
    $item = PortfolioItem::factory()->create([
        'title'    => 'Shaft Part',
        'category' => 'CNC Turning',
        'material' => 'AISI 304 Stainless Steel',
    ]);

    expect($item->title)->toBe('Shaft Part')
        ->and($item->category)->toBe('CNC Turning')
        ->and($item->is_active)->toBeTrue();
});

it('scopes active items ordered by sort_order', function () {
    PortfolioItem::factory()->create(['is_active' => true, 'sort_order' => 2]);
    PortfolioItem::factory()->create(['is_active' => true, 'sort_order' => 1]);
    PortfolioItem::factory()->inactive()->create();

    expect(PortfolioItem::active()->get())->toHaveCount(2)
        ->and(PortfolioItem::active()->first()->sort_order)->toBe(1);
});

it('scopes featured items correctly', function () {
    PortfolioItem::factory()->featured()->create();
    PortfolioItem::factory()->create(['is_featured' => false, 'is_active' => true]);

    expect(PortfolioItem::featured()->get())->toHaveCount(1);
});

it('has cover and gallery media collections', function () {
    $item = PortfolioItem::factory()->create();
    $collections = $item->getRegisteredMediaCollections()->pluck('name');

    expect($collections)->toContain('cover')
        ->and($collections)->toContain('gallery');
});
