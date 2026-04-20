<?php

use App\Models\Service;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('creates a service with all fields', function () {
    $service = Service::factory()->create([
        'title'      => 'CNC Turning',
        'slug'       => 'cnc-turning',
        'is_active'  => true,
        'sort_order' => 1,
    ]);

    expect($service->title)->toBe('CNC Turning')
        ->and($service->is_active)->toBeTrue()
        ->and($service->slug)->toBe('cnc-turning');
});

it('auto-generates slug from title on creation', function () {
    $service = Service::factory()->create(['title' => 'CNC Milling Service', 'slug' => '']);

    expect($service->slug)->toBe('cnc-milling-service');
});

it('scopes active services ordered by sort_order', function () {
    Service::factory()->create(['is_active' => true, 'sort_order' => 2, 'title' => 'B Service']);
    Service::factory()->create(['is_active' => true, 'sort_order' => 1, 'title' => 'A Service']);
    Service::factory()->inactive()->create(['title' => 'Inactive Service']);

    $results = Service::active()->get();

    expect($results)->toHaveCount(2)
        ->and($results->first()->title)->toBe('A Service');
});

it('has cover and gallery media collections', function () {
    $service = Service::factory()->create();
    $collections = $service->getRegisteredMediaCollections()->pluck('name');

    expect($collections)->toContain('cover')
        ->and($collections)->toContain('gallery');
});
