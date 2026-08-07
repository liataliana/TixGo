<?php
// [Magfi Adi Radza Putra] - Routes TixGo E-Ticketing System

use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\TicketPrintController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\VillaController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\TrainController;
use App\Http\Controllers\TicketController;

// =======================================================
// LOGOUT DARURAT & HOME / LANDING PAGE
// =======================================================
Route::get('/force-logout', function (Request $request) {
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
});

// [Magfi Adi Radza Putra] - Landing Page (PUBLIC, tanpa auth)
Route::get('/', function () { return view('home'); })->name('home');

// =======================================================
// AUTH (Login, Register, dll)
// =======================================================
require __DIR__ . '/auth.php';

// =======================================================
// DASHBOARD REDIRECT (Setelah Login)
// [Magfi Adi Radza Putra] - Redirect otomatis berdasarkan role
// =======================================================
Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    
    if ($role === 'super_admin') {
        return redirect()->route('superadmin.dashboard');
    }
    if ($role === 'manager') {
        return redirect()->route('manager.dashboard');
    }
    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// =======================================================
// ROUTE USER (Role: user)
// =======================================================
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/search-flight', [UserController::class, 'search'])->name('search');
    Route::get('/orders', [UserController::class, 'orders'])->name('orders');
    Route::post('/book-flight', [UserController::class, 'store'])->name('booking.store');
    Route::get('/payment/{id}', [UserController::class, 'paymentForm'])->name('payment.form');
    Route::post('/payment/{id}', [UserController::class, 'uploadPayment'])->name('payment.upload');
});

// =======================================================
// ROUTE MANAGER (Role: manager)
// [Magfi Adi Radza Putra] - Panel Manager dengan CRUD Tiket
// =======================================================
Route::middleware(['auth', 'role:manager'])
    ->prefix('manager')
    ->name('manager.')
    ->group(function () {
        Route::get('/dashboard', [ManagerController::class, 'dashboard'])->name('dashboard');
        Route::get('/flights', [ManagerController::class, 'flightsIndex'])->name('flights.index');
        Route::post('/flights', [ManagerController::class, 'store'])->name('flights.store');
        Route::get('/payments', [ManagerController::class, 'paymentsIndex'])->name('payments.index');
        Route::put('/payments/{id}/confirm', [ManagerController::class, 'confirmPayment'])->name('payments.confirm');
        Route::get('/users', [ManagerController::class, 'usersIndex'])->name('users.index');
        
        // CRUD Tiket (TixGo Tickets)
        Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
        Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
        Route::get('/tickets/{id}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
        Route::put('/tickets/{id}', [TicketController::class, 'update'])->name('tickets.update');
        Route::delete('/tickets/{id}', [TicketController::class, 'destroy'])->name('tickets.destroy');
    });

// =======================================================
// ROUTE SUPER ADMIN (Role: super_admin)
// [Magfi Adi Radza Putra] - Panel Super Admin
// =======================================================
Route::middleware(['auth', 'role:super_admin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
        
        // Kelola Users
        Route::get('/users', [SuperAdminController::class, 'users'])->name('users.index');
        Route::get('/users/{id}/edit', [SuperAdminController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [SuperAdminController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [SuperAdminController::class, 'destroy'])->name('users.destroy');
        Route::put('/users/{id}/role', [SuperAdminController::class, 'updateRole'])->name('users.updateRole');
        
        // Kelola Flights & Payments
        Route::get('/flights', [SuperAdminController::class, 'flights'])->name('flights.index');
        Route::get('/payments', [SuperAdminController::class, 'payments'])->name('payments.index');
        Route::get('/reports', [SuperAdminController::class, 'reports'])->name('reports.index');
        
        // CRUD Tiket (SuperAdmin juga bisa)
        Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
        Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
        Route::get('/tickets/{id}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
        Route::put('/tickets/{id}', [TicketController::class, 'update'])->name('tickets.update');
        Route::delete('/tickets/{id}', [TicketController::class, 'destroy'])->name('tickets.destroy');
    });

// =======================================================
// PROFILE (Semua user yang login)
// =======================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/download-ticket/{code}', [TicketPrintController::class, 'download'])->name('ticket.download');
});

// =======================================================
// ROUTE PUBLIK - PENERBANGAN
// =======================================================
Route::get('/flights', [FlightController::class, 'index'])->name('flights.index');
Route::get('/flights/{id}', [FlightController::class, 'show'])->name('flights.show');
Route::get('/flight/search', [FlightController::class, 'search'])->name('flight.search');

// =======================================================
// ROUTE PUBLIK - HOTEL, VILLA, KERETA, BUS
// =======================================================
Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
Route::get('/hotels/search', [HotelController::class, 'search'])->name('hotels.search');
Route::get('/villas', [VillaController::class, 'index'])->name('villas.index');
Route::get('/villas/search', [VillaController::class, 'search'])->name('villas.search');
Route::get('/trains', [TrainController::class, 'index'])->name('trains.index');
Route::get('/trains/{id}', [TrainController::class, 'show'])->name('trains.show');
Route::get('/trains/search', [TrainController::class, 'search'])->name('trains.search');
Route::get('/buses', [BusController::class, 'index'])->name('buses.index');
Route::get('/buses/search', [BusController::class, 'search'])->name('buses.search');

// =======================================================
// ROUTE BOOKING (AUTH REQUIRED)
// =======================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/bookings/create/{flightId}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings/store/{flightId}', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/checkout/{bookingId}', [BookingController::class, 'checkout'])->name('bookings.checkout');
    Route::post('/bookings/pay', [BookingController::class, 'pay'])->name('bookings.pay');
    Route::get('/bookings/success/{bookingId}', [BookingController::class, 'success'])->name('bookings.success');
    Route::get('/bookings/download/{bookingId}', [BookingController::class, 'downloadTicket'])->name('bookings.download');
    Route::get('/bookings/create/train', function() { return view('bookings.create'); })->name('bookings.create.train');
    Route::post('/bookings/store/train', [BookingController::class, 'storeTrain'])->name('bookings.store.train');
});