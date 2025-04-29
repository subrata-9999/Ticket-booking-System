<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Event\EventController;
use App\Http\Controllers\Booking\BookingController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->group(function () {
    Route::get('register', [RegisterController::class, 'index'])->name('auth.register'); // transfer to register page
    Route::post('register', [RegisterController::class, 'register'])->name('auth.register.submit');

    Route::get('login', [LoginController::class, 'index'])->name('auth.login'); // transfer to login page
    Route::post('login', [LoginController::class, 'login'])->name('auth.login.submit');

    Route::get('logout', [LoginController::class, 'logout'])->name('auth.logout'); // logout
});
Route::middleware(['auth'])->group(function () {
    Route::prefix('event')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('event.index');
    });

    Route::prefix('booking')->group(function () {
        Route::get('/', [BookingController::class, 'getAllBookings'])->name('booking.home');
        Route::get('book-event/{id}', [BookingController::class, 'getEventBooking'])->name('booking.event');
        Route::get('details/{id}', [BookingController::class, 'getBookingDetails'])->name('booking.details');
        Route::post('create', [BookingController::class, 'createBooking'])->name('booking.create');
        Route::delete('delete/{id}', [BookingController::class, 'deleteBooking'])->name('booking.delete');
    });
});
