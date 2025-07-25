<?php
use App\Http\Controllers\Admin\AdminController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StampController;
use App\Http\Controllers\CpointController;
use App\Http\Controllers\CustomRouteController;
use App\Http\Controllers\GrouphikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StampCommentController;
use App\Http\Controllers\RouterController;
use App\Http\Controllers\BlueHikeController;
use App\Http\Controllers\GrouphikeCommentController;
use App\Http\Middleware\IsAdmin;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('welcome');

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
    return Inertia::render('restrictions');
})->middleware(['auth', 'verified'])->name('restrictions');

Route::resource('custompoints', CpointController::class)->middleware(['auth', 'verified']);

Route::resource('stampcomments', StampCommentController::class)->only([
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
    Route::get('join_private_hike', [GrouphikeController::class, 'join_private_hike'])->name('grouphikes.join_private_hike');
    Route::post('join_private_hike_store', [GrouphikeController::class, 'join_private_hike_store'])->name('grouphikes.join_private_hike_store');
    Route::post('grouphikes/join', [GrouphikeController::class, 'join'])->name('grouphikes.join');
    Route::post('grouphikes/cancel', [GrouphikeController::class, 'cancel'])->name('grouphikes.cancel');
});

Route::resource('grouphikecomments', GrouphikeCommentController::class)->only([
    'store',
])->middleware(['auth', 'verified']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('grouphikes', GrouphikeController::class);

    Route::resource('bluehikes', BlueHikeController::class)->except('create');
    Route::get('/bluehikes/create/{hike}', [BlueHikeController::class, 'create'])->name('bluehikes.create');
    Route::get('/bluehikes/progress/{hike}', [BlueHikeController::class, 'progress'])->name('bluehikes.progress');
    Route::post('/bluehikes/savediary', [BlueHikeController::class, 'savediary'])->name('bluehikes.savediary');
    Route::get('/plannedhikes', [BlueHikeController::class, 'plannedhikes'])->name('bluehikes.plannedhikes');
    Route::post('/completebluestage', [BlueHikeController::class, 'completehike'])->name('bluehikes.completehike');
});

Route::post('/api/get-route', [RouterController::class, 'getRoute']);

// Admin routes
Route::middleware(['auth', 'verified',IsAdmin::class])->group(function () {
    Route::resource('Admin', AdminController::class);

;
});

require __DIR__ . '/auth.php';
