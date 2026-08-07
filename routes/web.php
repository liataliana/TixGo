<?php

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

// =======================================================
// LOGOUT DARURAT & HOME
// =======================================================
Route::get('/force-logout', function (Request $request) {
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
});

Route::get('/', function () { return view('home'); })->name('home');

// =======================================================
// AUTH
// =======================================================
require __DIR__ . '/auth.php';

// =======================================================
// DASHBOARD REDIRECT (Setelah Login)
// =======================================================
Route::get('/dashboard', function () {
    $user = auth()->user();
    $role = $user->role;
    
    if ($role === 'super_admin' || $role === 'admin') {
        return redirect('/superadmin/dashboard');  // ✅ URL LANGSUNG
    }
    if ($role === 'manager' || $role === 'admin_maskapai') {
        return redirect('/manager/dashboard');     // ✅ URL LANGSUNG
    }
    return redirect('/user/home');  // ✅ URL LANGSUNG KE HOME USER
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
// ROUTE MANAGER / ADMIN MASAPAKAI
// =======================================================
Route::middleware(['auth', 'role:manager,admin_maskapai'])
    ->prefix('manager')
    ->name('manager.')
    ->group(function () {
        Route::get('/dashboard', [ManagerController::class, 'dashboard'])->name('dashboard');
        Route::get('/flights', [ManagerController::class, 'flightsIndex'])->name('flights.index');
        Route::post('/flights', [ManagerController::class, 'store'])->name('flights.store');
        Route::get('/payments', [ManagerController::class, 'paymentsIndex'])->name('payments.index');
        Route::put('/payments/{id}/confirm', [ManagerController::class, 'confirmPayment'])->name('payments.confirm');
        Route::get('/users', [ManagerController::class, 'usersIndex'])->name('users.index');
    }); 

// =======================================================
// ROUTE SUPER ADMIN ✅ DIPERBAIKI (TAMBAH role:super_admin,admin)
// =======================================================
Route::middleware(['auth', 'role:super_admin,admin'])  // ✅ TAMBAHKAN INI!
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return '<h1 style="color:blue; font-size:48px;">👑 SUPER ADMIN DASHBOARD</h1><p>Route Super Admin BERHASIL!</p>';
        })->name('dashboard');

        Route::get('/users', function () {
            return '<h1 style="color:blue;">👥 DAFTAR USER</h1><p>Halaman users Super Admin</p>';
        })->name('users');

        Route::get('/payments', function () {
            return '<h1 style="color:blue;">💳 PEMBAYARAN</h1><p>Halaman payments Super Admin</p>';
        })->name('payments');

        Route::get('/flights', function () {
            return '<h1 style="color:blue;">✈️ PENERBANGAN</h1><p>Halaman flights Super Admin</p>';
        })->name('flights');

        Route::get('/reports', function () {
            return '<h1 style="color:blue;">📊 LAPORAN</h1><p>Halaman reports Super Admin</p>';
        })->name('reports');
    });

// =======================================================
// PROFILE (Semua user yang login)
// =======================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Download Ticket
    Route::get('/download-ticket/{code}', [TicketPrintController::class, 'download'])->name('ticket.download');
});

// =======================================================
// ROUTE PUBLIK - PENERBANGAN
// =======================================================
Route::get('/flights', [FlightController::class, 'index'])->name('flights.index');
Route::get('/flights/{id}', [FlightController::class, 'show'])->name('flights.show');
Route::get('/flight/search', [FlightController::class, 'search'])->name('flight.search');

// =======================================================
// ROUTE PUBLIK - HOTEL
// =======================================================
Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
Route::get('/hotels/search', [HotelController::class, 'search'])->name('hotels.search');

// =======================================================
// ROUTE PUBLIK - VILLA
// =======================================================
Route::get('/villas', [VillaController::class, 'index'])->name('villas.index');
Route::get('/villas/search', [VillaController::class, 'search'])->name('villas.search');

// =======================================================
// ROUTE PUBLIK - KERETA
// =======================================================
Route::get('/trains', [TrainController::class, 'index'])->name('trains.index');
Route::get('/trains/{id}', [TrainController::class, 'show'])->name('trains.show');
Route::get('/trains/search', [TrainController::class, 'search'])->name('trains.search');

// =======================================================
// ROUTE PUBLIK - BUS
// =======================================================
Route::get('/buses', [BusController::class, 'index'])->name('buses.index');
Route::get('/buses/search', [BusController::class, 'search'])->name('buses.search');

// =======================================================
// ROUTE BOOKING (AUTH REQUIRED)
// =======================================================
Route::middleware(['auth'])->group(function () {
    // Booking Pesawat
    Route::get('/bookings/create/{flightId}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings/store/{flightId}', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/checkout/{bookingId}', [BookingController::class, 'checkout'])->name('bookings.checkout');
    Route::post('/bookings/pay', [BookingController::class, 'pay'])->name('bookings.pay');
    Route::get('/bookings/success/{bookingId}', [BookingController::class, 'success'])->name('bookings.success');
    Route::get('/bookings/download/{bookingId}', [BookingController::class, 'downloadTicket'])->name('bookings.download');
    
    // Booking Kereta
    Route::get('/bookings/create/train', function() { 
        return view('bookings.create'); 
    })->name('bookings.create.train');
    Route::post('/bookings/store/train', [BookingController::class, 'storeTrain'])->name('bookings.store.train');
});

// =======================================================
// ROUTE LAPORAN (untuk Manager & Super Admin)
// =======================================================
Route::middleware(['auth', 'role:manager,admin_maskapai'])->group(function () {
    Route::get('/manager/reports', function() { 
        return view('manager.reports'); 
    })->name('manager.reports');
});

Route::middleware(['auth', 'role:super_admin,admin'])->group(function () {
    Route::get('/superadmin/reports', function() { 
        return view('superadmin.reports'); 
    })->name('superadmin.reports');
});