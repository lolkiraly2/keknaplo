<?php

use App\Http\Controllers\CpointController;
use App\Http\Controllers\ProfileController;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use PhpParser\Node\Stmt\Return_;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('home', function () {

    return Inertia::render("Home");
 
 });

 Route::get('/map', function () {
    return Inertia::render('map');
})->middleware(['auth', 'verified'])->name('map');

Route::get('/korlatozasok', function () {
    return Inertia::render('korlatozasok');
})->middleware(['auth', 'verified'])->name('korlatozasok');

Route::resource('custompoints', CpointController::class)->middleware(['auth', 'verified']);

Route::get('/mapteszt', function () {
    return view('maps');
})->middleware(['auth', 'verified'])->name('probaterkep');

require __DIR__.'/auth.php';
