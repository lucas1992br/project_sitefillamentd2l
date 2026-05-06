<?php

namespace App\Http\Controllers\Site;

use App\Models\Certification;
use App\Models\CatalogItem;
use App\Models\Client;
use App\Models\News;
use App\Models\PortfolioItem;
use App\Models\Service;
use App\Models\SiteContent;
use Illuminate\View\View;

class HomeController
{
    public function __invoke(): View
    {
        return view('site.home', [
            'services'             => Service::active()->where('show_on_home', true)->with('media')->take(4)->get(),
            'featuredItems'        => PortfolioItem::active()->where('show_on_home', true)->take(4)->get(),
            'featuredCatalogItems' => CatalogItem::active()->with('category')->featured()->take(4)->get(),
            'certifications'       => Certification::active()->get(),
            'clients'              => Client::active()->featured()->with('media')->take(8)->get(),
            'latestNews'           => News::published()->with('media')->take(4)->get(),
            'siteContent'          => SiteContent::instance(),
        ]);
    }
}
