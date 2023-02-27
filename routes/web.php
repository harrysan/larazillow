<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ListingOfferController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\NotificationSeenController;
use App\Http\Controllers\RealtorListingController;
use App\Http\Controllers\RealtorListingImageController;
use App\Http\Controllers\RelatorListingAcceptOfferController;
use App\Http\Controllers\UserAccountController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [IndexController::class, 'index']);
Route::get('/hello', [IndexController::class, 'show']);

// Create Account
Route::resource('user-account', UserAccountController::class)
    ->only(['create', 'store']);

// Auth Route All (Login)
Route::get('login', [AuthController::class, 'create'])->name('login');
Route::post('login', [AuthController::class, 'store'])->name('login.store');
Route::get('logout', [AuthController::class, 'destroy'])->name('logout');

// Verification Email Route
Route::get('/email/verify', function () {
    return inertia('Auth/VerifyEmail');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect()
        ->route('listing.index')
        ->with('success', 'Email was verified!');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return redirect()
        ->back()
        ->with('success', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
// throttle using Rate Limiting 
// throttle([many times],[minute])

// Listing Route All
// Route::resource('listing', ListingController::class)->only(['create', 'store'])->middleware('auth');
Route::resource('listing', ListingController::class)->only(['index', 'show']);

// Offer All Route
Route::resource('listing.offer', ListingOfferController::class)->middleware('auth')->only(['store']);

// Notification Route
Route::resource('notification', NotificationController::class)
    ->middleware('auth')
    ->only('index');

Route::put(
    'notification/{notification}/seen',
    NotificationSeenController::class
)->middleware('auth')->name('notification.seen');

// Realtor
Route::prefix('realtor')
    ->name('realtor.')
    ->middleware('auth', 'verified')
    ->group(function () {
        Route::resource('listing', RealtorListingController::class)->withTrashed();
        //->only(['create', 'store', 'index', 'destroy', 'edit', 'update']);

        // Single Action Controller
        // only has 1 invoke method
        Route::name('offer.accept')
            ->put(
                'offer/{offer}/accept',
                RelatorListingAcceptOfferController::class
            );

        Route::resource('listing.image', RealtorListingImageController::class)
            ->only(['create', 'store', 'destroy']);
    });
