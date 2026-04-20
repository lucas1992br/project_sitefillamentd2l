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
            'services'             => Service::active()->take(4)->get(),
            'featuredItems'        => PortfolioItem::active()->featured()->take(3)->get(),
            'featuredCatalogItems' => CatalogItem::active()->with('category')->featured()->take(4)->get(),
            'certifications'       => Certification::active()->take(6)->get(),
            'clients'              => Client::active()->featured()->take(4)->get(),
            'siteContent'          => SiteContent::instance(),
        ]);
    }
}
