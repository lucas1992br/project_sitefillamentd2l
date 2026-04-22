<?php

namespace App\Http\Controllers\Site;

use App\Models\Service;
use Illuminate\View\View;

class ServicesController
{
    public function index(): View
    {
        $services = Service::active()->with('media')->get();

        return view('site.services.index', compact('services'));
    }
}
