<?php

namespace App\Http\Controllers\Site;

use App\Models\News;
use Illuminate\View\View;

class NewsController
{
    public function index(): View
    {
        $news = News::published()->with('media')->paginate(12);

        return view('site.news.index', compact('news'));
    }

    public function show(string $slug): View
    {
        $item = News::published()->where('slug', $slug)->with('media')->firstOrFail();

        $related = News::published()
            ->where('id', '!=', $item->id)
            ->with('media')
            ->take(3)
            ->get();

        return view('site.news.show', compact('item', 'related'));
    }
}
