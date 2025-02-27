<?php

use Inertia\Inertia;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\StampController;
use App\Http\Controllers\CpointController;
use App\Http\Controllers\CustomRouteController;
use App\Http\Controllers\GrouphikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StampCommentController;
use App\Http\Controllers\RouterController;
use App\Models\GrouphikeComment;

Route::get('/', function () {
    return Inertia::render('Welcome');
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

Route::get('/restrictions', function () {
    return Inertia::render('korlatozasok');
})->middleware(['auth', 'verified'])->name('restrictions');

Route::resource('custompoints', CpointController::class)->middleware(['auth', 'verified']);
ROute::resource('stampcomments', StampCommentController::class)->middleware(['auth', 'verified']);

Route::get('/stamps/{hike}', [StampController::class, 'index'])->name('stamps.index');
Route::get('/stamps/{stamp}/show', [StampController::class, 'show'])->name('stamps.show');

Route::get('/mapteszt', function () {
    return view('maps');
})->middleware(['auth', 'verified'])->name('probaterkep');

Route::get('/customroute', function () {
    return Inertia::render('customroute/customroute');
})->name('customroute.customroute');

Route::resource('customroutes', CustomRouteController::class)->middleware(['auth', 'verified']);

Route::resource('grouphikes', GrouphikeController::class)->middleware(['auth', 'verified']);

Route::post('/api/get-route', [RouterController::class, 'getRoute']);

require __DIR__.'/auth.php';
