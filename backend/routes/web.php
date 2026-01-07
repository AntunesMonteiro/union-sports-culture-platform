<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\DashboardController;
use App\Models\Event;

/* PUBLICO */

Route::get('/', function () {
    $events = Event::where('is_active', true)
        ->whereDate('date', '>=', now()->toDateString())
        ->orderBy('date')
        ->orderBy('start_time')
        ->limit(3)
        ->get();

    return view('union.home', [
        'events' => $events,
    ]);
})->name('union.home');

Route::get('/reservas/nova', [ReservationController::class, 'create'])
    ->name('reservations.create');

Route::post('/reservas', [ReservationController::class, 'store'])
    ->name('reservations.store');


/* AUTH / DASHBOARD (Breeze) */

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


/* STAFF LOGIN */

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/admin/reservas', [ReservationController::class, 'index'])
        ->name('reservations.index');

    Route::post('/admin/reservas/{reservation}/estado', [ReservationController::class, 'updateStatus'])
        ->name('reservations.updateStatus');

    // Histórico (audit logs via Node API + Mongo)
    Route::get('/admin/reservas/{reservation}/historico', [ReservationController::class, 'history'])
        ->name('reservations.history');
});


/* ADMIN */

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/admin/mesas', [TableController::class, 'index'])->name('admin.tables.index');
    Route::get('/admin/mesas/criar', [TableController::class, 'create'])->name('admin.tables.create');
    Route::post('/admin/mesas', [TableController::class, 'store'])->name('admin.tables.store');
    Route::get('/admin/mesas/{table}/editar', [TableController::class, 'edit'])->name('admin.tables.edit');
    Route::put('/admin/mesas/{table}', [TableController::class, 'update'])->name('admin.tables.update');
    Route::delete('/admin/mesas/{table}', [TableController::class, 'destroy'])->name('admin.tables.destroy');
    
    Route::get('/admin/reservas/{reservation}/historico', [ReservationController::class, 'history'])->name('reservations.history');

    Route::get('/admin/eventos', [EventController::class, 'index'])->name('admin.events.index');
    Route::get('/admin/eventos/criar', [EventController::class, 'create'])->name('admin.events.create');
    Route::post('/admin/eventos', [EventController::class, 'store'])->name('admin.events.store');
    Route::get('/admin/eventos/{event}/editar', [EventController::class, 'edit'])->name('admin.events.edit');
    Route::put('/admin/eventos/{event}', [EventController::class, 'update'])->name('admin.events.update');
    Route::delete('/admin/eventos/{event}', [EventController::class, 'destroy'])->name('admin.events.destroy');
});

require __DIR__ . '/auth.php';
