@php($logoUrl = \App\Models\SiteContent::instance()->getFirstMediaUrl('logo'))

<div class="flex items-center gap-3">
    @if($logoUrl)
        <img src="{{ $logoUrl }}" alt="Logotipo" class="h-8 w-auto object-contain" />
    @endif
    <span class="font-semibold text-sm">Precision Machining — Admin</span>
</div>
