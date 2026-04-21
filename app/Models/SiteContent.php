<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SiteContent extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = [];

    public function casts(): array
    {
        return [
            'showcase_video_active' => 'boolean',
            'hero_poster_active'    => 'boolean',
            'about_active'          => 'boolean',
            'about_founded_year'    => 'integer',
            'robots_index'          => 'boolean',
        ];
    }

    public static function instance(): static
    {
        return static::firstOrCreate(['id' => 1], [
            'showcase_video_active' => true,
            'hero_poster_active'    => true,
            'about_active'          => true,
            'about_title'           => 'Sobre a D2L',
        ]);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('showcase_video')
            ->singleFile()
            ->acceptsMimeTypes(['video/mp4', 'video/webm', 'video/ogg']);

        $this->addMediaCollection('hero_poster')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/avif']);

        $this->addMediaCollection('about_image')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/avif']);

        $this->addMediaCollection('logo')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/avif', 'image/svg+xml']);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        //
    }
}
