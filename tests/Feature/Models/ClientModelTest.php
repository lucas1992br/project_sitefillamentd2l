<?php

use App\Models\Client;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('creates a client with all fields', function () {
    $client = Client::factory()->create([
        'name'     => 'Acme Corp',
        'industry' => 'Automotive',
    ]);

    expect($client->name)->toBe('Acme Corp')
        ->and($client->industry)->toBe('Automotive')
        ->and($client->is_active)->toBeTrue();
});

it('scopes active clients ordered by sort_order', function () {
    Client::factory()->create(['is_active' => true, 'sort_order' => 2]);
    Client::factory()->create(['is_active' => true, 'sort_order' => 1]);
    Client::factory()->inactive()->create();

    expect(Client::active()->get())->toHaveCount(2)
        ->and(Client::active()->first()->sort_order)->toBe(1);
});

it('scopes featured clients correctly', function () {
    Client::factory()->featured()->create();
    Client::factory()->create(['is_featured' => false]);

    expect(Client::featured()->get())->toHaveCount(1);
});

it('has logo media collection', function () {
    $client = Client::factory()->create();
    $collections = $client->getRegisteredMediaCollections()->pluck('name');

    expect($collections)->toContain('logo');
});
