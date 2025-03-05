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

ROute::resource('stampcomments', StampCommentController::class)->only([
    'store',
])->middleware(['auth', 'verified']);

Route::get('/stamps/{hike}', [StampController::class, 'index'])->name('stamps.index');
Route::get('/stamps/{stamp}/show', [StampController::class, 'show'])->name('stamps.show');

Route::resource('customroutes', CustomRouteController::class)->except([
    'edit', 'update'
])->middleware(['auth', 'verified']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('grouphikes', GrouphikeController::class);

    Route::get('mygrouphikes', [GrouphikeController::class, 'mygrouphikes'])->name('grouphikes.mygrouphikes');
    Route::get('futurehikes', [GrouphikeController::class, 'futurehikes'])->name('grouphikes.futurehikes');
    Route::post('grouphikes/join', [GrouphikeController::class, 'join'])->name('grouphikes.join');
    Route::post('grouphikes/cancel', [GrouphikeController::class, 'cancel'])->name('grouphikes.cancel');
});

Route::post('/api/get-route', [RouterController::class, 'getRoute']);

require __DIR__.'/auth.php';
