<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GiocatoreController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/giocatore/listaStagione', [GiocatoreController::class,'listaStagione'])->name('giocatore.listaStagione');
