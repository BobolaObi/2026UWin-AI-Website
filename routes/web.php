<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminEventsController;
use App\Http\Controllers\AdminLeadersController;
use App\Http\Controllers\AdminUsersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiteEventsController;
use App\Http\Controllers\SiteLeadersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('site.home');
})->name('home');

Route::get('/events', [SiteEventsController::class, 'index'])->name('events');
Route::get('/leaders', [SiteLeadersController::class, 'index'])->name('leaders');
Route::view('/join', 'site.join')->name('join');

Route::redirect('/index.html', '/', 301);
Route::redirect('/events.html', '/events', 301);
Route::redirect('/leaders.html', '/leaders', 301);
Route::redirect('/join.html', '/join', 301);
Route::redirect('/about.html', '/', 301);
Route::redirect('/projects.html', '/', 301);
Route::redirect('/footer.html', '/', 301);

Route::middleware(['auth', 'role:super_admin,admin'])->group(function () {
    Route::redirect('/admin', '/dashboard', 302)->name('admin.index');
    Route::get('/admin/users', [AdminUsersController::class, 'index'])->name('admin.users.index');
    Route::patch('/admin/users/{user}/role', [AdminUsersController::class, 'update_role'])->name('admin.users.role');

    Route::get('/admin/leaders', [AdminLeadersController::class, 'index'])->name('admin.leaders.index');
    Route::get('/admin/leaders/create', [AdminLeadersController::class, 'create'])->name('admin.leaders.create');
    Route::post('/admin/leaders', [AdminLeadersController::class, 'store'])->name('admin.leaders.store');
    Route::get('/admin/leaders/{leader}/edit', [AdminLeadersController::class, 'edit'])->name('admin.leaders.edit');
    Route::put('/admin/leaders/{leader}', [AdminLeadersController::class, 'update'])->name('admin.leaders.update');
    Route::delete('/admin/leaders/{leader}', [AdminLeadersController::class, 'destroy'])->name('admin.leaders.destroy');
});

Route::middleware(['auth', 'role:super_admin,admin,editor'])->group(function () {
    Route::get('/admin/events', [AdminEventsController::class, 'index'])->name('admin.events.index');
    Route::get('/admin/events/create', [AdminEventsController::class, 'create'])->name('admin.events.create');
    Route::post('/admin/events', [AdminEventsController::class, 'store'])->name('admin.events.store');
    Route::get('/admin/events/{event}/edit', [AdminEventsController::class, 'edit'])->name('admin.events.edit');
    Route::put('/admin/events/{event}', [AdminEventsController::class, 'update'])->name('admin.events.update');
    Route::patch('/admin/events/{event}/toggle', [AdminEventsController::class, 'toggle'])->name('admin.events.toggle');
    Route::delete('/admin/events/{event}', [AdminEventsController::class, 'destroy'])->name('admin.events.destroy');
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
