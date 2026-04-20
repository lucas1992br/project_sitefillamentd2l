<?php

use App\Models\SiteContent;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('creates a singleton instance with active flags defaulting to true', function () {
    $content = SiteContent::instance();

    expect($content->showcase_video_active)->toBeTrue()
        ->and($content->hero_poster_active)->toBeTrue();
});

it('returns the same instance on subsequent calls', function () {
    $first = SiteContent::instance();
    $second = SiteContent::instance();

    expect($first->id)->toBe($second->id);
    expect(SiteContent::count())->toBe(1);
});

it('casts active flags as booleans', function () {
    $content = SiteContent::instance();
    $content->update([
        'showcase_video_active' => false,
        'hero_poster_active'    => false,
    ]);

    $content->refresh();

    expect($content->showcase_video_active)->toBeFalse()
        ->and($content->hero_poster_active)->toBeFalse();
});

it('can toggle showcase video active independently', function () {
    $content = SiteContent::instance();
    $content->update(['showcase_video_active' => false]);

    $content->refresh();

    expect($content->showcase_video_active)->toBeFalse()
        ->and($content->hero_poster_active)->toBeTrue();
});

it('can toggle hero poster active independently', function () {
    $content = SiteContent::instance();
    $content->update(['hero_poster_active' => false]);

    $content->refresh();

    expect($content->showcase_video_active)->toBeTrue()
        ->and($content->hero_poster_active)->toBeFalse();
});
