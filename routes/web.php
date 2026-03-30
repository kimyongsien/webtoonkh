<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\StoryController;
use App\Http\Controllers\ProfileController;


use App\Http\Controllers\Admin\FeedbackController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // User Features
    Route::post('/stories/{story}/toggle-list', [App\Http\Controllers\UserFeatureController::class, 'toggleList'])->name('stories.toggle-list');
    Route::post('/stories/{story}/rate', [App\Http\Controllers\UserFeatureController::class, 'rate'])->name('stories.rate');
    Route::post('/stories/{story}/feedback', [App\Http\Controllers\UserFeatureController::class, 'submitFeedback'])->name('stories.feedback');
});

use App\Http\Controllers\StoryController as PublicStoryController;

Route::get('/', [PublicStoryController::class, 'index'])->name('home');
Route::get('/search', [PublicStoryController::class, 'search'])->name('stories.search');
Route::get('/categories', [PublicStoryController::class, 'categories'])->name('categories.index');
Route::get('/about', function () { return view('about'); })->name('about');
Route::get('/story/{story}', [PublicStoryController::class, 'show'])->name('stories.show');
Route::get('/story/{story}/episode/{episode}', [PublicStoryController::class, 'episode'])->name('episodes.show');

Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('categories', CategoryController::class);
        Route::resource('stories', StoryController::class);
        Route::resource('stories.episodes', \App\Http\Controllers\Admin\EpisodeController::class)->except(['index', 'show']);
        Route::resource('feedback', FeedbackController::class)->only(['index', 'destroy']);
        Route::resource('inbox', \App\Http\Controllers\Admin\InboxController::class)->only(['index', 'destroy']);
    });

use App\Http\Controllers\InboxController;
Route::get('/inbox', [InboxController::class, 'create'])->name('inbox.create');
Route::post('/inbox', [InboxController::class, 'store'])->name('inbox.store');

require __DIR__.'/auth.php';
