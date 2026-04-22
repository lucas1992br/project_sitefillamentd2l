<?php

namespace App\Http\Controllers\Site;

use App\Models\Certification;
use App\Models\CatalogItem;
use App\Models\Client;
use App\Models\PortfolioItem;
use App\Models\Service;
use App\Models\SiteContent;
use Illuminate\View\View;

class HomeController
{
    public function __invoke(): View
    {
        return view('site.home', [
            'services'             => Service::active()->where('show_on_home', true)->with('media')->get(),
            'featuredItems'        => PortfolioItem::active()->where('show_on_home', true)->get(),
            'featuredCatalogItems' => CatalogItem::active()->with('category')->featured()->take(4)->get(),
            'certifications'       => Certification::active()->where('show_on_home', true)->get(),
            'clients'              => Client::active()->featured()->take(4)->get(),
            'siteContent'          => SiteContent::instance(),
        ]);
    }
}
