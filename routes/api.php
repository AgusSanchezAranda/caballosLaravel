<?php
  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReservaController;

  
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
  
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
     
Route::middleware('auth:sanctum')->group( function () {
    Route::post('logout', [AuthController::class, 'logout']);    
    Route::post('reservas/turnos-disponibles', [ReservaController::class, 'turnosDisponibles']);
    Route::post('reservas/caballos-disponibles', [ReservaController::class, 'caballosDisponibles']);
    Route::get('reservas/nombre-caballo/{id_caballo}', [ReservaController::class, 'nombreCaballo']);
    Route::get('reservas/reservas-rw', [ReservaController::class, 'reservasRw']);
    Route::resource('reservas', ReservaController::class);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});