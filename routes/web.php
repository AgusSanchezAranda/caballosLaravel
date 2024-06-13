<?php

use App\Http\Controllers\CaballoController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\EmailController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

//Rutas para la verificación de email

//muestra la notificación de verificación de email, enlace para verificar
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

//maneja el click del usuario cuando verifica desde su mail, te lleva al inicio
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

//ruta para verificar de nuevo.Reenvio del enlace
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');



//rutas JavaScript
Route::get('/reservas/turnosDisponibles', [ReservaController::class, 'turnosDisponibles'])->name('reservas.turnosDisponibles');
Route::get('/reservas/caballosDisponibles', [ReservaController::class,'caballosDisponibles'])->name('reservas.caballosDisponibles');



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('caballos', CaballoController::class);
    Route::resource('reservas', ReservaController::class);


});