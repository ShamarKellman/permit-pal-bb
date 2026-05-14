<?php

declare(strict_types=1);

use App\Livewire\Test\PracticeTest as PracticeTestComponent;
use App\Livewire\Test\TestResult as TestResultComponent;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::get('/test', PracticeTestComponent::class)->name('test');
Route::get('/test/result', TestResultComponent::class)->name('test.result');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('/study', 'pages.study')->name('study');
    Route::view('/study/{category:slug}', 'pages.study')->name('study.category');
});

require __DIR__.'/settings.php';
