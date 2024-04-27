<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;


Route::post('/usuarios', [UsuarioController::class,'store']);
Route::get('/usuarios', [UsuarioController::class,'get']);
Route::delete('/usuarios',[UsuarioController::class,'destroyAll']);
