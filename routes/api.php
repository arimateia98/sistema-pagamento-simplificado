<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TransferenciaController;


Route::post('/usuarios', [UsuarioController::class,'store']);
Route::get('/usuarios', [UsuarioController::class,'get']);
Route::delete('/usuarios', [UsuarioController::class,'destroyAll']);


Route::post('/transferir', [TransferenciaController::class,'transferir']);
