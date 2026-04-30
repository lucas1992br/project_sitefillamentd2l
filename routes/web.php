<?php

use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\NewsController;
use App\Http\Controllers\Site\ServicesController;
use App\Livewire\User\Profile;
use App\Livewire\Users\Index;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

// Public site
Route::get('/', HomeController::class)->name('home');

Route::get('/services', [ServicesController::class, 'index'])->name('services.index');

Route::get('/portfolio', fn () => view('site.portfolio.index'))->name('portfolio.index');

Route::get('/catalog', fn () => view('site.catalog.index'))->name('catalog.index');

Route::get('/certifications', function () {
    return view('site.certifications.index', [
        'certifications' => \App\Models\Certification::active()->with('media')->get(),
    ]);
})->name('certifications.index');

Route::get('/noticias', [NewsController::class, 'index'])->name('news.index');

Route::get('/contact', fn () => view('site.contact'))->name('contact');

Route::get('/storage/{path}', function (string $path) {
    if (!Storage::disk('private')->exists($path)) {
        abort(404);
    }

    $mimeType = Storage::disk('private')->mimeType($path);

    return response()->stream(function () use ($path) {
        echo Storage::disk('private')->get($path);
    }, 200, [
        'Content-Type' => $mimeType,
        'Cache-Control' => 'public, max-age=86400',
    ]);
})->where('path', '.*');

// Auth-protected area
Route::middleware(['auth'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::get('/users', Index::class)->name('users.index');

    Route::get('/user/profile', Profile::class)->name('user.profile');
});

require __DIR__.'/auth.php';
