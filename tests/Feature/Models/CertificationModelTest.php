<?php

use App\Models\Certification;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('creates a certification with all fields', function () {
    $cert = Certification::factory()->create([
        'name'      => 'ISO 9001:2015',
        'issuer'    => 'Bureau Veritas',
        'issued_at' => '2022-03-15',
    ]);

    expect($cert->name)->toBe('ISO 9001:2015')
        ->and($cert->issuer)->toBe('Bureau Veritas')
        ->and($cert->issued_at)->toBeInstanceOf(\Illuminate\Support\Carbon::class);
});

it('detects expired certifications', function () {
    $expired = Certification::factory()->expired()->create();
    $valid   = Certification::factory()->create(['expires_at' => now()->addYear()]);

    expect($expired->isExpired())->toBeTrue()
        ->and($valid->isExpired())->toBeFalse();
});

it('returns false for isExpired when no expiry date set', function () {
    $cert = Certification::factory()->create(['expires_at' => null]);

    expect($cert->isExpired())->toBeFalse();
});

it('scopes active certifications', function () {
    Certification::factory()->create(['is_active' => true]);
    Certification::factory()->inactive()->create();

    expect(Certification::active()->get())->toHaveCount(1);
});

it('has certificate and logo media collections', function () {
    $cert = Certification::factory()->create();
    $collections = $cert->getRegisteredMediaCollections()->pluck('name');

    expect($collections)->toContain('certificate')
        ->and($collections)->toContain('logo');
});
