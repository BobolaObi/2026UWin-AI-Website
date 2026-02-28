<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('site.home');
})->name('home');

Route::view('/events', 'site.events')->name('events');
Route::view('/leaders', 'site.leaders')->name('leaders');
Route::view('/join', 'site.join')->name('join');

Route::redirect('/index.html', '/', 301);
Route::redirect('/events.html', '/events', 301);
Route::redirect('/leaders.html', '/leaders', 301);
Route::redirect('/join.html', '/join', 301);
Route::redirect('/about.html', '/', 301);
Route::redirect('/projects.html', '/', 301);
Route::redirect('/footer.html', '/', 301);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
