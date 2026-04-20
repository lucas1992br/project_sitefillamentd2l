<?php

use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\ServicesController;
use App\Livewire\User\Profile;
use App\Livewire\Users\Index;
use Illuminate\Support\Facades\Route;

// Public site
Route::get('/', HomeController::class)->name('home');

Route::get('/services', [ServicesController::class, 'index'])->name('services.index');

Route::get('/portfolio', fn () => view('site.portfolio.index'))->name('portfolio.index');

Route::get('/catalog', fn () => view('site.catalog.index'))->name('catalog.index');

Route::get('/certifications', fn () => view('site.certifications.index'))->name('certifications.index');

Route::get('/contact', fn () => view('site.contact'))->name('contact');

// Auth-protected area
Route::middleware(['auth'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::get('/users', Index::class)->name('users.index');

    Route::get('/user/profile', Profile::class)->name('user.profile');
});

require __DIR__.'/auth.php';
